@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    {{ __('Add Contact') }}
                </div>

                <div class="card-body">
                    <div class="form-body">
                        <form action="{{ route('contacts.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="contact_name" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" id="contact_name">
                            </div>
                            <div class="mb-3">
                                <label for="contact_company" class="form-label">Company</label>
                                <input type="text" name="company" class="form-control" id="contact_company">
                            </div>
                            <div class="mb-3">
                                <label for="contact_phone" class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control" id="contact_phone">
                            </div>
                            <div class="mb-3">
                                <label for="contact_email" class="form-label">Email</label>
                                <input type="name" name="email" class="form-control" id="contact_email">
                            </div>
                            <button type="submit" class="btn btn-primary float-end">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
