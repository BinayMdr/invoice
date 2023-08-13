
<html>
	<head>
		<meta charset="utf-8">
		<title>Invoice</title>
		<link rel="stylesheet" href="{{asset('assets/css/invoice.css')}}">
		<link rel="license" href="https://www.opensource.org/licenses/mit-license/">
	</head>
	<body>
			@php
				$invoice = \App\Models\Invoice::find($invoiceId);
				$setting = \App\Models\Setting::where('branch_id',$invoice->branch_id)->first();
				$customer = \App\Models\Customer::find($invoice->customer_id);
				$pan = \App\Models\GlobalSetting::where('name','pan')->first();
			@endphp
			<div>
				<h1>Invoice</h1>
				<br>
			
					<h1>{{$setting->name}}</h1>
					<h2>{{$setting->address}}</h2>
					<h2>{{$setting->number}}</h2>
					<h2>PAN: {{$pan->value}}</h2>
			</div>
		<article style="margin-top:50px">
			<address contenteditable>
				<p>Recipient</p>
				<p>{{$customer->name}}<br>{{$customer->phone_number}}</p>
			</address>
			<table class="meta">
				<tr>
					<th><span contenteditable>Invoice #</span></th>
					<td><span contenteditable>{{$invoice->invoice_number}}</span></td>
				</tr>
				<tr>
					<th><span contenteditable>Date</span></th>
					<td><span contenteditable>{{ \Carbon\Carbon::parse(now())->tz('Asia/Kathmandu') }}</span></td>
				</tr>
			</table>
			<table class="inventory">
				<thead>
					<tr>
						<th><span contenteditable>Item</span></th>
						<th><span contenteditable>Rate</span></th>
						<th><span contenteditable>Quantity</span></th>
						<th><span contenteditable>Price</span></th>
					</tr>
				</thead>
				<tbody>
					@foreach(\App\Models\InvoiceHasProduct::where('invoice_id',$invoice->id)->get() as $product)
						<tr>	
							<td><span contenteditable> {{\App\Models\Product::find($product->product_id)->name}}</span></td>
							<td><span data-prefix>Rs. </span><span contenteditable>{{ $product->price}}</span></td>
							<td><span contenteditable>{{$product->quantity}}</span></td>
							<td><span data-prefix>Rs. </span><span>{{ $product->total}}</span></td>
						</tr>
					@endforeach
				</tbody>
			</table>
			<table class="balance">
				<tr>
					<th><span contenteditable>Total</span></th>
					<td><span data-prefix>Rs. </span><span>{{$invoice->sub_total}}</span></td>
				</tr>
				<tr>
					<th><span contenteditable>Amount Paid</span></th>
					<td><span data-prefix>Rs.</span><span contenteditable>{{$invoice->discount_amount}} {{"(".$invoice->discount_percent."%)"}}</span></td>
				</tr>
				<tr>
					<th><span contenteditable>Balance Due</span></th>
					<td><span data-prefix>Rs. </span><span>{{$invoice->total}}</span></td>
				</tr>
			</table>
		</article>
		<p>
			Status: {{$invoice->status}}<br>
			Prepared By: {{\Auth::user()->name}}
		</p>
		<script>
			setTimeout(function () { window.print(); }, 3000);
			setTimeout(() => window.location.href = "{{route('edit.invoice',['invoice' => $invoice])}}", 3000)
		</script>
	</body>
</html>
