<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use PDF;

class InvoiceController extends Controller
{
    public function downloadInvoice($id)
    {
        // Retrieve the order based on the ID
        $order = Order::findOrFail($id); // Adjust this according to your model

        // Generate the PDF
        $pdf = PDF::loadView('subscriptions.invoice', compact('order'));
        
        // Download the PDF
        return $pdf->download('invoice.pdf');
    }
}