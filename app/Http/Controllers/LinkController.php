<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\Link;
use App\Models\Personel;
use App\Models\PersonelMateri;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'materi_id'       => 'required|exists:materis,id',
            'nama_link'       => 'required|string',
            'deksripsi_link'  => 'required|string',
            'link'            => 'required|file|mimes:pdf,doc,docx,ppt,pptx,mp4,zip|max:20480', // max 20MB
        ]);

        if ($request->hasFile('link')) {
            $file = $request->file('link');
            $filename = time().'_'.$file->getClientOriginalName();
            $filepath = $file->storeAs('uploads/link_materi', $filename, 'public');
        }

        Link::create([
            'materi_id'      => $request->materi_id,
            'nama_link'      => $request->nama_link,
            'deskripsi_link' => $request->deksripsi_link,
            'link'           => $filepath ?? null,
        ]);

        return back()->with('message', 'File berhasil diunggah.');
    }


    public function update(Request $request, $id)
    {
        $link = Link::findOrFail($id);

        $request->validate([
            'nama_link'       => 'required|string',
            'deskripsi_link'  => 'required|string',
            'link'            => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,mp4,zip|max:20480',
        ]);

        if ($request->hasFile('link')) {
            // hapus file lama jika ada
            if ($link->link && \Storage::disk('public')->exists($link->link)) {
                \Storage::disk('public')->delete($link->link);
            }

            $file = $request->file('link');
            $filename = time().'_'.$file->getClientOriginalName();
            $filepath = $file->storeAs('uploads/link_materi', $filename, 'public');
            $link->link = $filepath;
        }

        $link->nama_link = $request->nama_link;
        $link->deksripsi_link = $request->deksripsi_link;
        $link->save();

        return back()->with('message', 'File berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $link = Link::findOrFail($id);

        if ($link->link && \Storage::disk('public')->exists($link->link)) {
            \Storage::disk('public')->delete($link->link);
        }

        $link->delete();

        return back()->with('message', 'File berhasil dihapus.');
    }

}
