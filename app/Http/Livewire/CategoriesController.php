<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUpLoads; //trait
use Livewire\WithPagination;


class CategoriesController extends Component
{

    use WithFileUpLoads;
    use WithPagination;

    public $name, $search, $image, $selected_id, $pageTitle, $componentName;
    private $pagination = 3;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Categorias';
    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {
        if(strlen($this->search) > 0)
        $data = Category::where('name', 'like','%' . $this->search . '%')->paginate($this->pagination);
        else
        $data = Category::orderby('id','desc')->paginate($this->pagination);

        return view('livewire.category.categories',['categories' => $data])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    public function Edit($id)
    {
        $record = Category::find($id,['id','name','image']);
        $this->name = $record->name;
        $this->selected_id = $record->id;
        $this->image = null;

        $this->emit('show-modal', 'show modal!');
    }

    public function resetUI()
    {

    }


}
