<?php

namespace App\Livewire;

use App\Models\KategoriProduk;
use App\Models\Produk;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Throwable;
use Illuminate\Support\Str;

class ProdukList extends Component
{
    use WithPagination;
    use WithFileUploads;
    #[Title('Produk')]
    public $title = 'Produk';
    public $search = '';
    public $paginate = 10;
    public $postAdd = false;
    public $isStatus;

    public $id, $kategori_produk_id, $nama, $slug, $deskripsi, $berat, $harga, $stokAda, $gambar_old, $gambar;
    public $filterKategori;
    public $listStokAda = [];

    public function mount()
    {
        $this->title;
        $this->isStatus = 'create';
        $data = $this->getProdukQuery()->get();
        foreach ($data as $row) {
            $this->listStokAda[$row->id] = (bool) $row->stokAda;
        }
    }
    #[Computed()]
    public function listKategori()
    {
        return KategoriProduk::where('isActive', 1)->get();
    }
    public function render()
    {
        $data = $this->getProdukQuery()->paginate($this->paginate);
        return view('livewire.produk-list', [
            'data' => $data
        ]);
    }

    private function getProdukQuery()
    {
        return Produk::when($this->search, function ($query) {
            $query->where('nama', 'like', "%{$this->search}%");
        })->when($this->filterKategori, function ($query) {
            $query->where('kategori_produk_id', $this->filterKategori);
        });
    }
    public function udaptedSearch()
    {
        $this->resetPage();
    }
    public function blankForm()
    {
        $this->kategori_produk_id = '';
        $this->nama = '';
        $this->slug = '';
        $this->deskripsi = '';
        $this->berat = '';
        $this->harga = '';
        $this->stokAda = (bool) false;
        $this->gambar_old = '';
        $this->gambar = '';
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
        $data = Produk::find($id);
        $this->id = $data->id;
        $this->kategori_produk_id = $data->kategori_produk_id;
        $this->nama = $data->nama;
        $this->slug = $data->slug;
        $this->deskripsi = $data->deskripsi;
        $this->berat = $data->berat;
        $this->harga = $data->harga;
        $this->stokAda = (bool) $data->stokAda;
        $this->gambar_old = $data->gambar;
    }
    public function save()
    {
        $rules = [
            'nama' => 'required|min:3|max:100|unique:produks,nama,' . $this->id,
            'kategori_produk_id' => 'required',
            'berat' => 'required',
            'harga' => 'required',
            'deskripsi' => 'required|min:3|max:255',
        ];

        // kalau create, gambar wajib
        if ($this->isStatus == 'create') {
            $rules['gambar'] = 'required|image|max:2048';
        } elseif ($this->gambar) {
            // kalau edit dan upload gambar baru, validasi juga
            $rules['gambar'] = 'image|max:2048';
        }

        $this->validate($rules);

        $slug = Str::slug($this->nama);
        $data = [
            'kategori_produk_id' => $this->kategori_produk_id,
            'nama'              => $this->nama,
            'slug'              => $slug,
            'berat'             => $this->berat,
            'harga'             => $this->harga,
            'deskripsi'         => $this->deskripsi,
            'stokAda'           => (bool) $this->stokAda,
        ];

        // handle upload gambar
        if ($this->gambar) {
            $data['gambar'] = $this->gambar->store('produk', 'public');
        }

        if ($this->isStatus == 'create') {
            Produk::create($data);
            $msg = 'Data berhasil disimpan';
        } else {
            Produk::where('id', $this->id)->update($data);
            $msg = 'Data berhasil diedit';
        }

        $this->dispatch('swal', [
            'title' => 'Success!',
            'text'  => $msg,
            'icon'  => 'success',
        ]);

        $this->addPost();
        $this->dispatch('close-modal');
    }

    // public function save()
    // {
    //     // dd($this->all());
    //     if ($this->isStatus == 'create') {
    //         $this->validate([
    //             'nama' => 'required|min:3|max:100|unique:produks,nama,' . $this->id,
    //             'kategori_produk_id' => 'required',
    //             'berat' => 'required',
    //             'harga' => 'required',
    //             'gambar' => 'required|image|max:2048',
    //             'deskripsi' => 'required|min:3|max:255',
    //         ]);
    //         $path = $this->gambar->store('produk', 'public');
    //         $slug = Str::of($this->nama)->slug('-');
    //         Produk::create([
    //             'kategori_produk_id' => $this->kategori_produk_id,
    //             'nama' => $this->nama,
    //             'slug' => $slug,
    //             'berat' => $this->berat,
    //             'harga' => $this->harga,
    //             'gambar' => $path,
    //             'deskripsi' => $this->deskripsi,
    //             'stokAda' => (bool) $this->stokAda,
    //         ]);

    //         $this->dispatch('swal', [
    //             'title' => 'Success!',
    //             'text' => 'Data berhasil disimpan',
    //             'icon' => 'success',
    //         ]);
    //     } else {
    //         $this->validate([
    //             'nama' => 'required|min:3|max:100|unique:produks,nama,' . $this->id,
    //             'kategori_produk_id' => 'required',
    //             'berat' => 'required',
    //             'harga' => 'required',
    //             'deskripsi' => 'required|min:3|max:255',
    //         ]);

    //         $slug = Str::of($this->nama)->slug('-');
    //         if ($this->gambar) {
    //             $path = $this->gambar->store('produk', 'public');
    //             Produk::where('id', $this->id)
    //                 ->update([
    //                     'kategori_produk_id' => $this->kategori_produk_id,
    //                     'nama' => $this->nama,
    //                     'slug' => $slug,
    //                     'berat' => $this->berat,
    //                     'harga' => $this->harga,
    //                     'gambar' => $path,
    //                     'deskripsi' => $this->deskripsi,
    //                     'stokAda' => (bool) $this->stokAda,
    //                 ]);
    //         } else {
    //             Produk::where('id', $this->id)
    //                 ->update([
    //                     'kategori_produk_id' => $this->kategori_produk_id,
    //                     'nama' => $this->nama,
    //                     'slug' => $slug,
    //                     'berat' => $this->berat,
    //                     'harga' => $this->harga,
    //                     'deskripsi' => $this->deskripsi,
    //                     'stokAda' => (bool) $this->stokAda,
    //                 ]);
    //         }

    //         $this->dispatch('swal', [
    //             'title' => 'Success!',
    //             'text' => 'Data berhasil diedit',
    //             'icon' => 'success',
    //         ]);
    //     }
    //     $this->addPost();
    //     $this->dispatch('close-modal');
    // }
    public function updateStokAda($id)
    {
        // dd($this->all());
        Produk::where('id', $id)
            ->update([
                'stokAda' => $this->listStokAda[$id]
            ]);
    }
    public function cofirmDelete($id)
    {
        $this->dispatch('confirm', id: $id);
    }
    #[On('delete')]
    public function delete($id)
    {
        try {
            Produk::find($id)->delete();
            // Storage::disk('public')->delete($data->gambar);
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
