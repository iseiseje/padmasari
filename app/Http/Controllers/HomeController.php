<?php

namespace App\Http\Controllers;

use App\Services\DocumentService;

class HomeController extends Controller
{
    protected DocumentService $documentService;

    public function __construct(DocumentService $documentService)
    {
        $this->documentService = $documentService;
    }

    public function index()
    {
        $novelDoc = $this->documentService->getDocument('novel');
        $naskahDoc = $this->documentService->getDocument('naskah');
        $dramaDoc = $this->documentService->getDocument('drama');

        return view('home', compact(
            'novelDoc',
            'naskahDoc',
            'dramaDoc'
        ));
    }
}
