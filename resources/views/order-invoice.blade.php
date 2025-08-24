<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Order Invoice</title>
</head>
<body>
<div style="margin: 0;background: #fff;padding: 15px;font: 12px/ 1.5 'Helvetica', 'Arial', sans-serif;">
    <table
        style="width: 100%; border-collapse: collapse; display: table; border-spacing: 2px; margin-bottom: 0;line-height: 16px">
        <tbody>
        <tr>
            <td colspan="11" style="text-align: center;font-size: 14px"><b>Tax Invoice</b></td>
        </tr>
        <tr>
            <td colspan="11" style="height: 10px"></td>
        </tr>
        <tr>
            <td colspan="11">
                <img src="{{ $logo }}" alt="logo"
                     style="vertical-align: middle; border-style: none;max-width: 180px;max-height: 100px">
            </td>
        </tr>
        <tr>
            <td colspan="5"
                style="padding: .85rem 0; vertical-align: top;white-space:normal;line-height: 20px">
                <h6 style="font-size: 14px;margin-bottom: 5px">Company Address</h6>
                <b>{{ settings('company_name') }}</b><br>
                {{ settings('address_line_1') }} <br>
                {{ settings('address_line_2') }} <br>
                {{ settings('city') }} {{ settings('state') ? ",".settings('state') : "" }}
                {{ settings('pincode') ? "-".settings('pincode') : ""}}
                <br>
                Mobile : {{ $invoice->admin_mobile }}<br>
                Email : {{ $invoice->admin_email }}<br>
                @if(settings('gst_no'))
                    GST No : {{ settings('gst_no') }}<br>
                @endif
            </td>
            <td></td>
            <td colspan="5" style="padding: .85rem 0; vertical-align: top;white-space:normal;line-height: 20px">
                <h6 style="font-size: 14px;margin-bottom: 5px">Shipping Address</h6>
                <b>
                    {{ $invoice->member->user->name }} ({{ $invoice->member->code }})
                </b><br>
                {{ $invoice->address }}<br>
                {{ optional($invoice->city)->name }}<br>
                {{ optional($invoice->state)->name }}{{ $invoice->pincode ? "-".$invoice->pincode : "" }}<br>
                Mobile : {{ $invoice->phone }} <br>
                Email : {{ $invoice->email }} <br>
            </td>
        </tr>
        <tr>
            <td colspan="11" style="height: 20px"></td>
        </tr>
        <tr>
            <td colspan="5" style="padding: .35rem 0; vertical-align: top;font-size: 12px;white-space:normal;">
                <b>Order ID :</b>{{ $invoice->order_no }}
            </td>
            <td></td>
            <td colspan="5" style="padding: .35rem 0; vertical-align: top;font-size: 12px;white-space:normal;">
                <b>Order Date :</b>{{ $invoice->created_at->format('d M Y') }}
            </td>
        </tr>
        <tr>
            <td colspan="5" style="padding: .35rem 0; vertical-align: top;font-size: 12px;white-space:normal;">
                <b> Invoice ID :</b>{{ $invoice->invoice_no }}
            </td>
            <td></td>
            <td colspan="5" style="padding: .35rem 0; vertical-align: top;font-size: 12px;white-space:normal;">
                <b>Invoice Date :</b> {{ $invoice->created_at->format('d M Y') }}
            </td>
        </tr>
        <tr>
            <td colspan="11" style="height: 20px"></td>
        </tr>
        <tr>
            <th style="vertical-align: middle;border: 1px solid #ced0d2;padding: .25rem;font-size: 12px;">#</th>
            <th style="vertical-align: middle;border: 1px solid #ced0d2;padding: .25rem;font-size: 12px;">Name</th>
            <th style="vertical-align: middle;border: 1px solid #ced0d2;padding: .25rem;font-size: 12px;">Product Code
            </th>
            <th style="vertical-align: middle;border: 1px solid #ced0d2;padding: .25rem;font-size: 12px;">HSN</th>
            <th style="vertical-align: middle;border: 1px solid #ced0d2;padding: .25rem;font-size: 12px;">Qty</th>
            <th style="vertical-align: middle;border: 1px solid #ced0d2;padding: .25rem;font-size: 12px;">MRP</th>
            <th style="vertical-align: middle;border: 1px solid #ced0d2;padding: .25rem;font-size: 12px;">DP</th>
            <th style="vertical-align: middle;border: 1px solid #ced0d2;padding: .25rem;font-size: 12px;">Taxable Amount</th>
            <th style="vertical-align: middle;border: 1px solid #ced0d2;padding: .25rem;font-size: 12px;">Tax Type</th>
            <th style="vertical-align: middle;border: 1px solid #ced0d2;padding: .25rem;font-size: 12px;">GST Amount</th>
            <th style="vertical-align: middle;border: 1px solid #ced0d2;padding: .25rem;font-size: 12px;">Total Amount</th>
        </tr>
        @foreach($invoice->products()->with('product')->get() as $key => $invoiceProduct)
            <tr>
                <td style="vertical-align: middle;border: 1px solid #ced0d2;padding: .25rem;font-size: 12px;text-align: center">{{ $key + 1 }}</td>
                <td style="vertical-align: middle;border: 1px solid #ced0d2;padding: .25rem;font-size: 12px;text-align: center">{{ $invoiceProduct->product->name }}</td>
                <td style="vertical-align: middle;border: 1px solid #ced0d2;padding: .25rem;font-size: 12px;text-align: center">{{ $invoiceProduct->product->sku }}</td>
                <td style="vertical-align: middle;border: 1px solid #ced0d2;padding: .25rem;font-size: 12px;text-align: center">{{ $invoiceProduct->hsn_code }}</td>
                <td style="vertical-align: middle;border: 1px solid #ced0d2;padding: .25rem;font-size: 12px;text-align: center">{{ $invoiceProduct->quantity }}</td>
                <td style="vertical-align: middle;border: 1px solid #ced0d2;padding: .25rem;font-size: 12px;text-align: center">{{ round($invoiceProduct->mrp,2) }}</td>
                <td style="vertical-align: middle;border: 1px solid #ced0d2;padding: .25rem;font-size: 12px;text-align: center">{{ round($invoiceProduct->dp,2) }}</td>
                <td style="vertical-align: middle;border: 1px solid #ced0d2;padding: .25rem;font-size: 12px;text-align: center">{{ $invoiceProduct->taxable_value }}</td>
                <td style="vertical-align: middle;border: 1px solid #ced0d2;padding: .25rem;font-size: 12px;text-align: center">{{$invoiceProduct->sgst_percentage>=0&&$invoiceProduct->cgst_percentage>=0 && $invoice->admin_state==$invoice->state->name ?'SGST/CGST':'IGST'}}</td>
                <td style="vertical-align: middle;border: 1px solid #ced0d2;padding: .25rem;font-size: 12px;text-align: center">{{ $invoiceProduct->sgst_amount+$invoiceProduct->cgst_amount+$invoiceProduct->igst_amount }}
                    ({{ $invoiceProduct->sgst_percentage+$invoiceProduct->cgst_percentage+$invoiceProduct->igst_percentage }}
                    %)
                </td>
                <td style="vertical-align: middle;border: 1px solid #ced0d2;padding: .25rem;font-size: 12px;text-align: center">{{ round($invoiceProduct->amount,2) }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="7" style="border: 1px solid #dee2e6; padding: .85rem; vertical-align: top;font-size: 12px;">No
                return on scheme products
            </td>
            <td colspan="2" style="vertical-align: middle;border: 1px solid #ced0d2;padding: .25rem;font-size: 12px;">
                <b>Total Charge</b></td>
            <td colspan="2" style="vertical-align: middle;border: 1px solid #ced0d2;padding: .25rem;font-size: 12px;">
                Rs. {{ round($invoice->total,2) }}</td>
        </tr>
        <tr>
            <td colspan="11" style="vertical-align: middle;border: 1px solid #ced0d2;padding: .85rem;font-size: 12px;">
                Amount in Word : <b style="text-transform: capitalize">{{ $amountInWords }}</b></td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>
