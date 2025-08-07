@extends('layout')

@section('content')
<div class="container">
    <h2 class="heading">Contact Manager</h2>

    <a href="{{ url('/contacts/form') }}" class="btn primary">Add New Contact</a>

    {{-- XML Import --}}
    <form id="importForm" enctype="multipart/form-data" class="form">
        @csrf
        <label class="form-label">Import Contacts (XML):</label>
        <input type="file" name="xml_file" id="xml_file" accept=".xml" class="form-input">
        <button type="submit" class="btn primary">Import</button>
    </form>

    {{-- Contact Table --}}
    <form id="bulkDeleteForm">
        <table class="styled-table">
            <thead>
                <tr>
                    <th><input type="checkbox" id="select-all"></th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="contact-table">
                @foreach($contacts as $contact)
                    <tr id="row-{{ $contact->id }}">
                        <td><input type="checkbox" class="row-checkbox" value="{{ $contact->id }}"></td>
                        <td>{{ $contact->name }}</td>
                        <td>{{ $contact->phone }}</td>
                        <td>
                            <a href="{{ url('/contacts/form/' . $contact->id) }}" class="btn primary">Edit</a>
                            <button type="button" class="btn danger delete-btn" data-id="{{ $contact->id }}">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <button type="submit" class="btn danger" style="margin-top: 15px;">Delete Selected</button>
    </form>
</div>
@endsection

@section('scripts')
<style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background: #eef2f7;
        margin: 0;
        padding: 20px;
    }
    .container {
        max-width: 960px;
        margin: auto;
        background: #fff;
        padding: 30px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
    }
    .heading {
        color: #212529;
        font-size: 28px;
        margin-bottom: 25px;
    }
    .styled-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        font-size: 16px;
    }
    .styled-table th, .styled-table td {
        border: 1px solid #dee2e6;
        padding: 14px 16px;
        text-align: left;
    }
    .styled-table th {
        background-color: #007bff;
        color: #fff;
    }
    .styled-table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    .btn {
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        margin-right: 5px;
        transition: all 0.3s ease-in-out;
    }
    .btn.primary {
        background-color: #007bff;
        color: #fff;
    }
    .btn.danger {
        background-color: #dc3545;
        color: #fff;
    }
    .btn:hover {
        opacity: 0.9;
    }
    .form {
        margin-top: 20px;
        margin-bottom: 20px;
    }
    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #495057;
    }
    .form-input {
        display: block;
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ced4da;
        border-radius: 4px;
    }
    input[type="checkbox"] {
        transform: scale(1.2);
        cursor: pointer;
    }
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }});

// Delete single contact
$(document).on('click', '.delete-btn', function () {
    if (!confirm('Delete this contact?')) return;
    const id = $(this).data('id');
    $.ajax({
        url: `/contacts/${id}`,
        type: 'DELETE',
        success: function () {
            $(`#row-${id}`).fadeOut();
        },
        error: function () {
            alert('Delete failed');
        }
    });
});

// Bulk delete
$('#bulkDeleteForm').on('submit', function (e) {
    e.preventDefault();
    const ids = $('.row-checkbox:checked').map(function () {
        return $(this).val();
    }).get();
    if (ids.length === 0) {
        alert('Please select at least one contact.');
        return;
    }
    if (!confirm('Delete selected contacts?')) return;
    $.ajax({
        url: '/contacts/bulk-delete',
        type: 'POST',
        data: { ids },
        success: function () {
            ids.forEach(id => $(`#row-${id}`).fadeOut());
        },
        error: function () {
            alert('Bulk delete failed.');
        }
    });
});

// Select all checkboxes
$('#select-all').on('click', function () {
    $('.row-checkbox').prop('checked', this.checked);
});

// Import XML
$('#importForm').submit(function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    $.ajax({
        url: '/contacts/import',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function () {
            alert('Imported successfully');
            location.reload();
        },
        error: function () {
            alert('Import failed');
        }
    });
});
</script>
@endsection