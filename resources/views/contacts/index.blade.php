@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 mb-3">
            <span class="float-end">
                <a href="{{ route('contacts.create') }}" class="btn btn-primary btn-sm">Add Contact</a>
            </span>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-9">{{ __('Contacts') }}</div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="contact_search" placeholder="Search">
                        </div>
                    </div>
                    
                </div>

                <div class="card-body">
                    <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">NAME</th>
                          <th scope="col">COMPANY</th>
                          <th scope="col">PHONE</th>
                          <th scope="col">EMAIL</th>
                          <th scope="col" class="text-center">Action</th>
                        </tr>
                      </thead>
                      <tbody id="contacts_data">
                        @forelse($contacts as $contact)
                            <tr>
                                <td>{{ $contact->name }}</td>
                                <td>{{ $contact->company }}</td>
                                <td>{{ $contact->phone }}</td>
                                <td>{{ $contact->email }}</td>
                                <td class="text-center">
                                    <a href="{{ route('contacts.edit', [$contact->id]) }}">Edit</a> |
                                    <a href="{{ route('contacts.delete', [$contact->id]) }}" onclick="return confirm('Are you sure you want to DELETE?')">Delete</a>
                                </td>
                            </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No records.</td>
                        </tr>
                        @endforelse
                      </tbody>
                    </table>
                    <div class="text-center" id="contacts_pagination">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#contact_search").keyup(function() {
            var search_name = $('#contact_search').val();
            $.ajax({
                type: "get",
                dataType: "json",
                url: "{{ route('contacts.search') }}",
                data: {
                    search: search_name
                },
                success: function(response) {
                    let contacts_data = "";
                    let contacts_pagination = "";

                    if (response.data.length) {
                        $.each(response.links, function(index, link) {
                            if (link.url) {
                                contacts_pagination += `<a class="btn-sm btn btn-primary" href="${link.url}&search=${search_name}">${link.label}</a> `;
                            }

                        });

                        $('#contacts_pagination').html(contacts_pagination);


                        $.each(response.data, function(index, item) {
                            item.company = !item.company ? '' : item.company;
                            item.phone = !item.phone ? '' : item.phone;
                            item.email = !item.email ? '' : item.email;

                            contacts_data +=`<tr>
                                <td>${item.name}</td>
                                <td>${item.company}</td>
                                <td>${item.phone}</td>
                                <td>${item.email}</td>
                                <td class="text-center">
                                    <a href="/contacts/${item.id}/edit">Edit</a> |
                                    <a href="/contacts/${item.id}/delete" onclick="return confirm('Are you sure you want to DELETE?')">Delete</a>
                                </td>
                            </tr>`;
                        });

                        $('#contacts_data').html(contacts_data);


                    }
                }
            });
        });
    });
</script>
@endsection
