@extends('emails.index')
@section('content')
<h4>দলিল আবেদন নং : {{en2bnNumber($dolil->code)}}</h4>
<h4>দলিলের প্রকার : {{$dolil->officeInformation ? $dolil->officeInformation->dolilType->name : ''}}</h4>
<h4>ক্রেতা/গ্রহীতা : {{isset($dolil->buyers[0]->name) ? $dolil->buyers[0]->name : ''}}</h4>
<h4>বিক্রেতা/দাতা : {{isset($dolil->sellers[0]->name) ? $dolil->sellers[0]->name : ''}}</h4>
<h4>
	দলিলের মূল্য : 
	@if(isset($dolil->officeInformation->has_infrastructure) && $dolil->officeInformation->has_infrastructure == 1)
		{{en2bnNumber(bdt($dolil->price ? $dolil->price->total_land_value+$dolil->price->total_installation_cost : 0))}}/-
		@else
		{{en2bnNumber(bdt($dolil->price ? $dolil->price->total_land_value : 0))}}/-
	@endif
</h4>
<h4>অগ্রগতি : {{en2bnNumber(howMuch($dolil->id))}}% সম্পন্ন</h4>
@endsection