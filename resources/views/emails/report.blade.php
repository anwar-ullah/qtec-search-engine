@extends('emails.index')
@section('content')
	<h4>নাম : {{ $request->name }}</h4>
	<h4>ফোন নাম্বার : {{ $request->phone }}</h4>
	<h4>ই-মেইল : {{ $request->email }}</h4>
	<h4>সাবজেক্ট : {{ $request->subject }}</h4>
	<h4>বিস্তারিত:</h4>
	<p>
		{{ $request->details }}
	</p>
@endsection