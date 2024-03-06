## Library API

## Usage
To use the Library API, you can make HTTP requests to the provided endpoints.

## Endpoints
<ul dir="auto">
    <li><code>GET /books?query=phrase</code> - Retrieves a list of books with pagination. You can add a query to search by phrase</li>
    <li><code>GET /books/{id}</code> - Retrieves detailed information about a specific book, identified by their ID.</li>
    <li><code>GET /customers</code> - Retrieves a list of all customers</li>
    <li><code>GET /customers/{id}</code> - Retrieves detailed information about a specific customer, identified by their ID.</li>
    <li><code>POST /customers</code> - Adds a new customer. Requires customer information in the request body.</li>
    <li><code>DELETE /customers/{id}</code> - Deletes a specific customer record, identified by their ID.</li>
    <li><code>POST /books/{id}/customers{id}/borrow</code> - Borrow a book</li>
    <li><code>POST /books/{id}/drop</code> - Return the book</li>
</ul>
