<!DOCTYPE html>
<html>
<head>
    <title>Debug Hamburger Menu</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="p-8">
        <h1 class="text-2xl font-bold mb-4">Test du Hamburger Menu</h1>
        
        <div class="mb-4">
            <button id="testToggle" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Test Toggle
            </button>
        </div>
        
        <div id="testSidebar" class="w-64 bg-gray-800 text-white p-4 fixed left-0 top-0 h-full transform -translate-x-full transition-transform duration-300">
            <h2 class="text-xl font-bold mb-4">Sidebar Test</h2>
            <ul class="space-y-2">
                <li><a href="#" class="block py-2 hover:bg-gray-700">Menu 1</a></li>
                <li><a href="#" class="block py-2 hover:bg-gray-700">Menu 2</a></li>
                <li><a href="#" class="block py-2 hover:bg-gray-700">Menu 3</a></li>
            </ul>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.getElementById('testToggle');
            const sidebar = document.getElementById('testSidebar');
            
            console.log('Toggle element:', toggle);
            console.log('Sidebar element:', sidebar);
            
            if (toggle && sidebar) {
                let isOpen = false;
                
                toggle.addEventListener('click', function() {
                    console.log('Toggle clicked!');
                    isOpen = !isOpen;
                    
                    if (isOpen) {
                        sidebar.classList.remove('-translate-x-full');
                        sidebar.classList.add('translate-x-0');
                        console.log('Sidebar opened');
                    } else {
                        sidebar.classList.add('-translate-x-full');
                        sidebar.classList.remove('translate-x-0');
                        console.log('Sidebar closed');
                    }
                });
            } else {
                console.error('Elements not found!');
            }
        });
    </script>
</body>
</html>
