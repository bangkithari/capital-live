<?php

namespace Tests\Feature;

use App\Models\AplikasiDocument;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StoredFileCleanupTest extends TestCase
{
    use RefreshDatabase;

    public function test_aplikasi_document_deletion_removes_related_storage_file(): void
    {
        Storage::fake('local');

        Storage::put('documents/test.pdf', 'content');

        $document = AplikasiDocument::create([
            'aplikasi_id' => 'APP0000000000001',
            'document_type' => 'POLICY',
            'document_name' => 'Test Document',
            'file_path' => 'documents/test.pdf',
            'file_extension' => 'pdf',
            'uploaded_by' => '000001',
        ]);

        Storage::assertExists('documents/test.pdf');

        $document->delete();

        Storage::assertMissing('documents/test.pdf');
    }

    public function test_aplikasi_document_deletion_ignores_missing_storage_file(): void
    {
        Storage::fake('local');

        $document = AplikasiDocument::create([
            'aplikasi_id' => 'APP0000000000002',
            'document_type' => 'POLICY',
            'document_name' => 'Missing Document',
            'file_path' => 'documents/missing.pdf',
            'file_extension' => 'pdf',
            'uploaded_by' => '000001',
        ]);

        $document->delete();

        $this->assertDatabaseMissing('aplikasi_document', [
            'document_aplikasi_id' => $document->getKey(),
        ]);
    }
}
