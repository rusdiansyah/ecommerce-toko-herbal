<?php

namespace App\Livewire;

use App\Models\KategoriProduk;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Throwable;
class KategoriList extends Component
{
    use WithPagination;
    #[Title('Kategori')]
    public $title = 'Kategori';
    public $search = '';
    public $paginate = 10;
    public $postAdd = false;
    public $isStatus;

    public $id, $nama, $deskripsi, $isActive;

    public function mount()
    {
        $this->title;
        $this->isStatus = 'create';
    }
    public function render()
    {
        $data = KategoriProduk::when($this->search, function ($query) {
            $query->where('nama', 'like', "%{$this->search}%");
        })
            ->paginate($this->paginate);
        return view('livewire.kategori-list', [
            'data' => $data
        ]);
    }
    public function udaptedSearch()
    {
        $this->resetPage();
    }
    public function blankForm()
    {
        $this->nama = '';
        $this->deskripsi = '';
        $this->isActive = (bool) false;
    }
    public function addPost()
    {
        $this->postAdd = true;
        $this->isStatus = 'create';
        $this->blankForm();
    }
    public function close()
    {
        $this->postAdd = false;
    }

    public function edit($id)
    {
        $this->isStatus = 'edit';
        $data = KategoriProduk::find($id);
        $this->id = $data->id;
        $this->nama = $data->nama;
        $this->deskripsi = $data->deskripsi;
        $this->isActive =(bool) $data->isActive;
    }
    public function save()
    {
        $this->validate([
            'nama' => 'required|min:3|unique:kategori_produks,nama,' . $this->id,
            'deskripsi' => 'required'
        ]);
        KategoriProduk::updateOrCreate(['id' => $this->id], [
            'nama' => $this->nama,
            'deskripsi' => $this->deskripsi,
            'isActive' => $this->isActive,
        ]);
        if ($this->isStatus == 'create') {
            $this->dispatch('swal', [
                'title' => 'Success!',
                'text' => 'Data berhasil disimpan',
                'icon' => 'success',
            ]);
            $this->addPost();
        } else {
            $this->dispatch('swal', [
                'title' => 'Success!',
                'text' => 'Data berhasil diedit',
                'icon' => 'success',
            ]);
        }
        $this->dispatch('close-modal');
    }
    public function cofirmDelete($id)
    {
        $this->dispatch('confirm', id: $id);
    }
    #[On('delete')]
    public function delete($id)
    {
        try {
            KategoriProduk::find($id)->delete();
            $this->dispatch('swal', [
                'title' => 'Success!',
                'text' => 'Data berhasil dihapus',
                'icon' => 'success',
            ]);
        } catch (Throwable $e) {
            report($e);
            $this->dispatch('swal', [
                'title' => 'Error!',
                'text' => 'Data tidak dapat dihapus',
                'icon' => 'Error',
            ]);
            return false;
        }
    }
}
