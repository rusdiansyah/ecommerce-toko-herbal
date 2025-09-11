<?php

namespace App\Livewire;

use App\Models\Rekening;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Throwable;
class RekeningIndex extends Component
{
    #[Title('Rekening')]
    public $title = 'Rekening';
    public $search = '';
    public $postAdd = false;
    public $isStatus;
    public $id, $bank, $nomor, $nama;

    public function mount()
    {
        $this->title;
        $this->isStatus = 'create';
    }
    public function render()
    {
        $data = Rekening::when($this->search, function ($query) {
            $query->where('nama', 'like', "%{$this->search}%");
        })
            ->get();
        return view('livewire.rekening-index',[
            'data' => $data
        ]);
    }
    public function udaptedSearch()
    {
        $this->resetPage();
    }
    public function blankForm()
    {
        $this->bank = '';
        $this->nomor = null;
        $this->nama = '';
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
        $data = Rekening::find($id);
        $this->id = $data->id;
        $this->bank = $data->bank;
        $this->nomor = $data->nomor;
        $this->nama = $data->nama;

    }
    public function save()
    {
        $this->validate([
            'bank' => 'required|min:3|unique:rekenings,bank,' . $this->id,
            'nama' => 'required',
            'nomor' => 'required',
        ]);
        Rekening::updateOrCreate(['id' => $this->id], [
            'bank' => $this->bank,
            'nomor' => $this->nomor,
            'nama' => $this->nama,
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
            Rekening::find($id)->delete();
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
