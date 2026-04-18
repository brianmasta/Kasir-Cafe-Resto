<?php

namespace App\Livewire;

use App\Models\Menu;
use Livewire\Component;

class MenuManager extends Component
{
    public $name, $price, $category;
    public $menus = [];
    public $editId = null;

    public function mount()
    {
        $this->loadMenus();
    }

    public function loadMenus()
    {
        $this->menus = Menu::latest()->get();
    }

    public function save()
    {
        $this->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'category' => 'required',
        ]);

        if ($this->editId) {
            Menu::find($this->editId)->update([
                'name' => $this->name,
                'price' => $this->price,
                'category' => $this->category,
            ]);
        } else {
            Menu::create([
                'name' => $this->name,
                'price' => $this->price,
                'category' => $this->category,
            ]);
        }

        $this->reset(['name', 'price', 'category', 'editId']);
        $this->loadMenus();
    }

    public function edit($id)
    {
        $menu = Menu::find($id);

        $this->editId = $menu->id;
        $this->name = $menu->name;
        $this->price = $menu->price;
        $this->category = $menu->category;
    }

    public function delete($id)
    {
        Menu::find($id)->delete();
        $this->loadMenus();
    }

    public function render()
    {
        return view('livewire.menu-manager')
            ->layout('layouts.app');
    }
}
