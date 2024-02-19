@extends("layout.template")

@section("content")

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Users Account</h3>
                <!-- <p class="text-subtitle text-muted">A sortable, searchable, paginated table without dependencies tha.</p> -->
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Settings</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Users</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    Users
                </h5>
            </div>
            <div class="card-body" style="overflow-x:auto;">
                <table class="table table-striped" id="users-table">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th class="text-center">Status</th>
                            <th>Last Login</th>
                            <th>CreatedAt</th>
                            <th class="text-center" style="width: max-content;">Action</th>
                        </tr>
                    </thead>
                    <tbody id="users-table-body">
                      
                    </tbody>
                    <tfoot>
                        <tr style="height: 20em" id="user-table-spinner">
                            <td colspan="9" class="container">
                                <div class="d-flex justify-content-center">
                                    <div class="spinner-border text-primary text-bold" role="status" style="width: 3rem; height: 3rem;">
                                        <span class="sr-only"></span>
                                    </div>
                                </div>
                            </td>
                       </tr>
                    </tfoot>
                </table>
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-end" id="users-table-pagination">
                    </ul>
                </nav>
            </div>
        </div>

    </section>
</div>

@endsection


@push("custom-script")
    <script type="module" src="{{ asset('js/pages/users.js') }}"></script>
@endpush