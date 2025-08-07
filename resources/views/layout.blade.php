<!DOCTYPE html>
<html>
<head>
    <title>Contact Manager</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        .container { max-width: 900px; margin: auto; }
        .styled-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .styled-table th, .styled-table td { border: 1px solid #ddd; padding: 10px; }
        .styled-table th { background-color: #f4f4f4; }
        #editModal { display: none; margin-top: 20px; border: 1px solid #ccc; padding: 15px; background: #f9f9f9; }
        button { padding: 6px 12px; margin-right: 5px; }
    </style>
</head>
<body>
    @yield('content')
    @yield('scripts')
</body>
</html>
