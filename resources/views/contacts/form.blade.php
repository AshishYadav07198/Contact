@extends('layout')

@section('content')
<div class="container">
    <h2 class="heading">{{ isset($contact) ? 'Edit Contact' : 'Add Contact' }}</h2>

    <form id="contactForm" class="form">
        @csrf
        <input type="hidden" id="contact_id" value="{{ $contact->id ?? '' }}">

        <label class="form-label">Name</label>
        <input type="text" id="name" name="name" class="form-input" value="{{ $contact->name ?? '' }}" required>

        <label class="form-label">Phone</label>
        <input type="text" id="phone" name="phone" class="form-input" value="{{ $contact->phone ?? '' }}" required maxlength="15">

        <button type="submit" class="btn primary">Save Contact</button>
        <a href="{{ route('contacts.index') }}" class="btn">Back to List</a>
    </form>
</div>
@endsection

@section('scripts')
<style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background: #f8f9fa;
        margin: 0;
        padding: 20px;
    }

    .container {
        max-width: 700px;
        margin: auto;
        background: #fff;
        padding: 30px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        border-radius: 8px;
    }

    .heading {
        color: #343a40;
        margin-bottom: 25px;
        text-align: center;
    }

    .form {
        margin-top: 10px;
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
        margin-bottom: 20px;
        border: 1px solid #ced4da;
        border-radius: 4px;
        font-size: 16px;
    }

    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 15px;
        text-decoration: none;
        margin-right: 10px;
    }

    .btn.primary {
        background-color: #007bff;
        color: #fff;
    }

    .btn:hover {
        opacity: 0.9;
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });


   $('#contactForm').on('submit', function (e) {
    e.preventDefault();

    const id = $('#contact_id').val();
    const name = $('#name').val().trim();
    let phone = $('#phone').val().trim();

    // Client-side validation
  const nameRegex = /^[\p{L}\s'.-]+$/u;

    // const phoneRegex = /^\+\d{2}\d{13}$/;  // +CC followed by 10 digits

    if (!name) {
        alert('Name is required');
        return;
    }
    if (!nameRegex.test(name)) {
        alert('Name should only contain letters and spaces');
        return;
    }
    if (!phone) {
        alert('Phone is required');
        return;
    }
   

    const url = id ? '/contacts/' + id : '/contacts';
    const method = id ? 'PUT' : 'POST';

    $.ajax({
        url: url,
        type: method,
        data: { name: name, phone: phone },
        success: function () {
            alert('Saved successfully');
            window.location.href = "/contacts";
        },
        error: function (xhr) {
            alert('Something went wrong');
            console.log(xhr.responseText);
        }
    });
});
</script>
@endsection
