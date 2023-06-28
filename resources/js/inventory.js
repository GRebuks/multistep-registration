document.addEventListener('DOMContentLoaded', function() {
    let cols = document.querySelectorAll('.inventory-col');
    let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    cols.forEach(function(col) {
        col.addEventListener('click', function() {
            let direction = 'ASC';

            if (col.classList.contains('active')) {
                if (col.innerHTML.includes('▲')) {
                    col.innerHTML = col.innerHTML.replace('▲', '▼');
                    direction = 'DESC';
                } else {
                    col.innerHTML = col.innerHTML.replace('▼', '▲');
                    direction = 'ASC';
                }
            }

            else {
                cols.forEach(function (col) {
                    col.classList.remove('active');
                    col.innerHTML = col.innerHTML.replace(' ▲', '');
                    col.innerHTML = col.innerHTML.replace(' ▼', '');
                });
                col.classList.add('active');
                col.innerHTML += ' ▲';
            }

            let id = col.getAttribute('data-id');
            let url = '/inventory/get/';

            let searchTerm = document.getElementById('search').value;
            if (searchTerm !== '') {
                url += searchTerm;
            } else {
                url += 'all';
            }

            url += '/' + id + '/' + direction;

            // Make a GET request to the url
            fetch(url, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(function(response) {
                return response.json();

            })
            .then(function(data) {
                UpdateTable(data);
            })
            .catch(function(error) {
                console.log(error);
            });
        });
    });

    let searchBtn = document.getElementById('search-btn');
    searchBtn.addEventListener('click', function() {
        // Get the search term
        let searchTerm = document.getElementById('search').value;
        let url = '/inventory/search/' + searchTerm;

        cols.forEach(function (col) {
            col.classList.remove('active');
            col.innerHTML = col.innerHTML.replace(' ▲', '');
            col.innerHTML = col.innerHTML.replace(' ▼', '');
        });

        // Make a GET request to the url
        fetch(url, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')

            }
        })
        .then(function(response) {
            return response.json();

        })
        .then(function(data) {
            UpdateTable(data);
        })
        .catch(function(error) {
            console.log(error);
        });
    });
    function UpdateTable(data) {
        let tableBody = document.querySelector('#inventory-table tbody');
        tableBody.innerHTML = '';

        data.forEach(function(item) {
            let row = document.createElement('tr');
            row.classList.add('odd:bg-white', 'even:bg-slate-50');
            row.innerHTML = `
                <td class="border border-slate-300">${item.name}</td>
                <td class="border border-slate-300">${item.description}</td>
                <td class="border border-slate-300">${item.quantity}</td>
                <td class="border border-slate-300">${item.price}</td>
                <td class="border border-slate-300">${item.category}</td>
                <td class="border border-slate-300">${item.user_id}</td>
                <td class="border border-slate-300">
                    <div class="flex flex-row gap-3 justify-evenly">
                        <a href="inventory/edit/${item.id}" class="text-blue-500">Edit</a>
                        <form action="inventory/delete/${item.id}" method="POST">
                            <input type="hidden" name="csrf" value=${csrf}>
                            <button type="submit" class="text-red-500 flex">
                                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                <span>Delete</span>
                            </button>
                        </form>
                    </div>
                </td>
            `;
            tableBody.appendChild(row);
        });
    }
});
