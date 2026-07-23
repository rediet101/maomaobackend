<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMenuItemRequest;
use App\Http\Requests\UpdateMenuItemRequest;
use App\Models\MenuItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MenuItemController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $items = MenuItem::when($search, function ($query, $search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        })
            ->latest()
            ->paginate(15)
            ->appends($request->query());

        return view('menu.index', compact('items'));
    }

    public function create(): View
    {
        return view('menu.form', ['item' => null]);
    }

    public function store(StoreMenuItemRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_available'] = $request->boolean('is_available');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $data['image'] = $image->store('menu', 'public');
            $data['image_data'] = $this->imageDataUrl($image);
        }

        MenuItem::create($data);

        return redirect()->route('menu.index')->with('success', 'Menu item created successfully!');
    }

    public function edit(MenuItem $menuItem): View
    {
        return view('menu.form', ['item' => $menuItem]);
    }

    public function update(UpdateMenuItemRequest $request, MenuItem $menuItem): RedirectResponse
    {
        $data = $request->validated();
        $data['is_available'] = $request->boolean('is_available');

        if ($request->hasFile('image')) {
            if ($menuItem->image) {
                Storage::disk('public')->delete($menuItem->image);
            }

            $image = $request->file('image');
            $data['image'] = $image->store('menu', 'public');
            $data['image_data'] = $this->imageDataUrl($image);
        }

        $menuItem->update($data);

        return redirect()->route('menu.index')->with('success', 'Menu item updated successfully!');
    }

    public function destroy(MenuItem $menuItem): RedirectResponse
    {
        if ($menuItem->image) {
            Storage::disk('public')->delete($menuItem->image);
        }

        $menuItem->delete();

        return redirect()->route('menu.index')->with('success', 'Menu item deleted.');
    }

    private function imageDataUrl(UploadedFile $image): string
    {
        return 'data:'.$image->getMimeType().';base64,'.base64_encode((string) file_get_contents($image->getRealPath()));
    }
}
