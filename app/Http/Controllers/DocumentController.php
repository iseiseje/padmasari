<?php

namespace App\Http\Controllers;

use App\Services\DocumentService;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    protected DocumentService $documentService;

    public function __construct(DocumentService $documentService)
    {
        $this->documentService = $documentService;
    }

    public function novel()
    {
        $document = $this->documentService->getDocument('novel');
        return view('documents.show', compact('document'));
    }

    public function naskah()
    {
        $document = $this->documentService->getDocument('naskah');
        return view('documents.show', compact('document'));
    }

    public function drama()
    {
        $document = $this->documentService->getDocument('drama');
        return view('documents.show', compact('document'));
    }
}
