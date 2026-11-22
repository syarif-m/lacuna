<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Contribution;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use RuntimeException;
use Throwable;

class CaseSubmissionController extends Controller
{
    public function create()
    {
        $classifications = Tag::where('tag_kind', 'CLASSIFICATION')
            ->orderBy('name')
            ->get();

        $verificationStatuses = Tag::where('tag_kind', 'VERIFICATION_STATUS')
            ->orderBy('name')
            ->get();

        $explanationStatuses = Tag::where('tag_kind', 'EXPLANATION_STATUS')
            ->orderBy('name')
            ->get();

        return view('member.cases.create', compact(
            'classifications',
            'verificationStatuses',
            'explanationStatuses'
        ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'proposed_title' => [
                'required',
                'string',
                'max:255',
            ],

            'proposed_summary' => [
                'required',
                'string',
            ],

            'central_mystery' => [
                'required',
                'string',
            ],

            'overview_content' => [
                'nullable',
                'string',
            ],

            'suggested_verification_status_tag_id' => [
                'required',
                'integer',
                Rule::exists('tags', 'id')
                    ->where(fn ($query) => $query->where(
                        'tag_kind',
                        'VERIFICATION_STATUS'
                    )),
            ],

            'suggested_explanation_status_tag_id' => [
                'required',
                'integer',
                Rule::exists('tags', 'id')
                    ->where(fn ($query) => $query->where(
                        'tag_kind',
                        'EXPLANATION_STATUS'
                    )),
            ],

            'tags' => [
                'required',
                'array',
                'min:1',
            ],

            'tags.*' => [
                'required',
                'integer',
                'distinct',
                Rule::exists('tags', 'id')
                    ->where(fn ($query) => $query->where(
                        'tag_kind',
                        'CLASSIFICATION'
                    )),
            ],

            'images' => [
                'nullable',
                'array',
                'max:3',
            ],

            'images.*.file' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'images.*.alt_text' => [
                'nullable',
                'string',
                'max:255',
            ],

            'images.*.caption' => [
                'nullable',
                'string',
                'max:255',
            ],

            'images.*.context_description' => [
                'nullable',
                'string',
            ],
        ]);

        // Alt text wajib diisi apabila gambar diunggah.
        $validator->after(function ($validator) use ($request) {
            $images = $request->file('images', []);

            foreach ($images as $index => $imageData) {
                if (
                    isset($imageData['file']) &&
                    $request->file("images.$index.file") &&
                    blank($request->input("images.$index.alt_text"))
                ) {
                    $validator->errors()->add(
                        "images.$index.alt_text",
                        'Alt text wajib diisi untuk setiap gambar.'
                    );
                }
            }
        });

        $validated = $validator->validate();

        // Menyimpan path file agar bisa dibersihkan
        // apabila transaksi database gagal.
        $storedPaths = [];

        try {
            DB::transaction(function () use (
                $validated,
                &$storedPaths
            ) {
                // 1. Buat record utama Contribution.
                $contribution = Contribution::create([
                    'submitted_by' => Auth::id(),
                    'contribution_type' => 'CASE_CREATE',
                    'current_status' => 'PENDING',
                ]);

                // 2. Simpan detail pengajuan Case.
                $contribution->caseData()->create([
                    'proposed_title' => $validated['proposed_title'],
                    'proposed_summary' => $validated['proposed_summary'],
                    'central_mystery' => $validated['central_mystery'],
                    'overview_content' => $validated['overview_content'] ?? null,

                    'suggested_verification_status_tag_id' =>
                        $validated['suggested_verification_status_tag_id'],

                    'suggested_explanation_status_tag_id' =>
                        $validated['suggested_explanation_status_tag_id'],
                ]);

                // 3. Simpan klasifikasi yang dipilih.
                $contribution->tags()->sync($validated['tags']);

                // 4. Simpan gambar ke penyimpanan privat.
                foreach ($validated['images'] ?? [] as $index => $imageData) {
                    $file = $imageData['file'] ?? null;

                    if (!$file) {
                        continue;
                    }

                    $path = $file->store(
                        "contributions/{$contribution->id}",
                        'local'
                    );

                    if (!$path) {
                        throw new RuntimeException(
                            'Gagal menyimpan gambar pengajuan.'
                        );
                    }

                    $storedPaths[] = $path;

                    $contribution->images()->create([
                        'temporary_image_path' => $path,
                        'alt_text' => $imageData['alt_text'],
                        'caption' => $imageData['caption'] ?? null,
                        'context_description' =>
                            $imageData['context_description'] ?? null,
                        'sort_order' => $index,
                    ]);
                }
            });
        } catch (Throwable $exception) {
            // Database rollback tidak otomatis menghapus file.
            // Karena itu, file yang sempat tersimpan dibersihkan.
            Storage::disk('local')->delete($storedPaths);

            report($exception);

            return back()
                ->withInput()
                ->withErrors([
                    'submission' =>
                        'Pengajuan belum berhasil disimpan. Silakan coba kembali.',
                ]);
        }

        return redirect()
            ->route('member.dashboard')
            ->with(
                'success',
                'Your Case submission has been sent and is waiting for Admin review.'
            );
    }
}