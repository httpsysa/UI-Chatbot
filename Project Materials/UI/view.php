<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot Database</title>

    <!-- Adding Bootstrap for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Adding Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            table-layout: fixed;
            /* Ensures columns have a fixed layout */
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            overflow: hidden;
            text-overflow: ellipsis;
            /* Adds ellipsis if the text overflows */
        }

        th {
            cursor: pointer;
        }

        tbody tr:nth-child(odd) {
            background-color: #f2f2f2;
        }

        tbody tr:nth-child(even) {
            background-color: #ffffff;
        }

        .pagination-controls {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 10px;
        }

        .page-number.active {
            font-weight: bold;
        }

        /* Specific widths for the columns */
        th:nth-child(1),
        td:nth-child(1) {
            width: 80px;
            /* Smaller width for the ID column */
            white-space: nowrap;
        }

        th:nth-child(4),
        td:nth-child(4) {
            width: 150px;
            white-space: nowrap;
        }


        th:nth-child(2),
        td:nth-child(2) {
            width: 40%;
            white-space: normal;
        }

        th:nth-child(3),
        td:nth-child(3) {
            width: 50%;
            white-space: normal;
        }
    </style>

</head>

<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between mb-4">
            <h1 class="mb-4">Administrator Database</h1>
            <button id="addEntryBtn" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Entry
            </button>
        </div>

        <div class="d-flex justify-content-between mb-3">
            <div class="d-flex align-items-center">
                <select id="pageLength" class="form-select me-2">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
            </div>
            <div class="d-flex align-items-center">
                <input type="text" id="searchBar" placeholder="Search..." class="form-control">
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4>Chatbot Query List</h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Query</th>
                            <th>Reply</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="entryList">
                        <!-- Dynamic content goes here -->
                    </tbody>
                </table>
                <div class="d-flex justify-content-between">
                    <div class="page-length">
                        Showing <span id="currentEntries">0</span> out of <span id="totalEntries">0</span> entries
                    </div>
                    <div class="pagination-controls">
                        <button id="prevPage" class="btn btn-secondary" disabled>Previous</button>
                        <div id="pageNumbers"></div>
                        <button id="nextPage" class="btn btn-secondary">Next</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div>
        <div>
            <br><br>
            <center>
                <div class="button-container">
                    <a href="chatbot.php" class="btn btn-primary">Back to Chatbot</a>
                    <a href="dashboard.php" class="btn btn-primary">Back to Dashboard</a>
                </div>
            </center>
            <br><br>
        </div>
    </div>


    <!-- Add/Edit Entry Modal -->
    <div class="modal fade" id="entryModal" tabindex="-1" role="dialog" aria-labelledby="entryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="entryModalLabel">Entry</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="entryId">
                    <div class="form-group">
                        <label for="query">Query</label>
                        <input type="text" class="form-control" id="query" required>
                    </div>
                    <div class="form-group">
                        <label for="reply">Reply</label>
                        <textarea class="form-control" id="reply" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="saveEntryBtn">Save changes</button>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function () {
            let entries = [];
            let currentPage = 1;
            let rowsPerPage = 10;

            $('#pageLength').change(function () {
                rowsPerPage = parseInt($(this).val());
                currentPage = 1; // Reset to the first page when the number of rows per page changes
                renderTable();
                renderPagination();
            });

            $('#searchBar').on('input', function () {
                currentPage = 1; // Reset to the first page when a search is performed
                renderTable();
                renderPagination();
            });

            function fetchEntries() {
                $.ajax({
                    url: "fetch_entries.php",
                    method: "GET",
                    success: function (data) {
                        entries = JSON.parse(data);
                        renderTable();
                        renderPagination();
                    },
                    error: function () {
                        $('#entryList').html('<tr><td colspan="4" class="text-center">Failed to load entries</td></tr>');
                    }
                });
            }

            function renderTable() {
                const searchQuery = $('#searchBar').val().toLowerCase();
                const filteredEntries = entries.filter(entry =>
                    entry.query.toLowerCase().includes(searchQuery) ||
                    entry.reply.toLowerCase().includes(searchQuery)
                );

                const startIndex = (currentPage - 1) * rowsPerPage;
                const paginatedEntries = filteredEntries.slice(startIndex, startIndex + rowsPerPage);

                $('#currentEntries').text(paginatedEntries.length);
                $('#totalEntries').text(filteredEntries.length);

                let tableContent = paginatedEntries.map(entry => `
            <tr>
                <td>${entry.id || ''}</td>
                <td>${entry.query || ''}</td>
                <td>${entry.reply || ''}</td>
                <td>
                    <button class="btn btn-sm btn-warning edit-entry" data-id="${entry.id}">Edit</button>
                    <button class="btn btn-sm btn-danger delete-entry" data-id="${entry.id}">Delete</button>
                </td>
            </tr>
        `).join('');
                $('#entryList').html(tableContent);
            }

            function renderPagination() {
                const searchQuery = $('#searchBar').val().toLowerCase();
                const filteredEntries = entries.filter(entry =>
                    entry.query.toLowerCase().includes(searchQuery) ||
                    entry.reply.toLowerCase().includes(searchQuery)
                );

                const totalPages = Math.ceil(filteredEntries.length / rowsPerPage);
                let pageNumbers = '';

                for (let i = 1; i <= totalPages; i++) {
                    const activeClass = i === currentPage ? 'active' : '';
                    pageNumbers += `<button class="btn btn-secondary ${activeClass}" data-page="${i}">${i}</button>`;
                }

                $('#pageNumbers').html(pageNumbers);
                $('#prevPage').prop('disabled', currentPage === 1);
                $('#nextPage').prop('disabled', currentPage === totalPages);
            }

            $('#pageNumbers').on('click', 'button', function () {
                currentPage = parseInt($(this).data('page'));
                renderTable();
                renderPagination();
            });

            $('#prevPage').click(function () {
                if (currentPage > 1) {
                    currentPage--;
                    renderTable();
                    renderPagination();
                }
            });

            $('#nextPage').click(function () {
                const totalPages = Math.ceil(entries.length / rowsPerPage);
                if (currentPage < totalPages) {
                    currentPage++;
                    renderTable();
                    renderPagination();
                }
            });

            $('#entryList').on('click', '.edit-entry', function () {
                const id = $(this).data('id');
                const entry = entries.find(entry => entry.id == id);

                if (entry) {
                    $('#entryId').val(entry.id);
                    $('#query').val(entry.query);
                    $('#reply').val(entry.reply);
                    $('#entryModal').modal('show');
                }
            });

            $('#entryList').on('click', '.delete-entry', function () {
                const id = $(this).data('id');
                if (confirm("Are you sure you want to delete this entry?")) {
                    $.ajax({
                        url: 'delete_entry.php',
                        method: 'POST',
                        data: { id },
                        success: function (response) {
                            fetchEntries();
                        },
                        error: function () {
                            alert("Error deleting entry!");
                        }
                    });
                }
            });

            $('#addEntryBtn').click(function () {
                $('#entryId').val('');
                $('#query').val('');
                $('#reply').val('');
                $('#entryModal').modal('show');
            });

            $('#saveEntryBtn').click(function (event) {
                event.preventDefault();
                const id = $('#entryId').val();
                const query = $('#query').val();
                const reply = $('#reply').val();

                if (!query || !reply) {
                    alert("Both query and reply fields are required.");
                    return;
                }

                $.ajax({
                    url: 'submit_entry.php',
                    method: 'POST',
                    data: { id, query, reply },
                    success: function (response) {
                        fetchEntries();
                        $('#entryModal').modal('hide');
                    },
                    error: function () {
                        alert("Error saving entry!");
                    }
                });
            });


            fetchEntries();
        });
    </script>
</body>

</html>