import '../axios.min.js'
import { getTimeAgo, handleError, spinnerAction } from '../function.js';
import { headers } from './app.js'

getUser();
function getUser(page = 1){
    axios.get(`/api/v1/users?page=${page}`, {
        headers: headers
    }).then(response => {
        const userData = response.data.data;
        const userTable = document.getElementById("users-table-body");
        const fragment = document.createDocumentFragment(); // Membuat fragmen dokumen untuk performa yang lebih baik
        spinnerAction("user-table-spinner","none")
        userTable.innerHTML = ''
        userData.data.forEach((item,index) => {
            const row = document.createElement("tr");
            row.id = `row-${item.id}`
            row.innerHTML = `
                <td class="text-center">${userData.from + index}</td>
                <td>${item.name}</td>
                <td>${item.username}</td>
                <td>${item.email}</td>
                <td>${item.user_role?.role_name}</td>
                <td class="text-center">
                    <i style="color:${item.status === '1' ? '#97ea36' : 'red'}" class="bi ${item.status === '1' ? 'bi-check-circle-fill' : 'bi-exclamation-circle'}"></i>
                </td>
                <td>${ item.user_login ? getTimeAgo(item.user_login.last_login) : '-' }</td>
                <td>${new Date(item.created_at).toLocaleDateString()}</td>
                <td class="text-center" id="user-action-button">
                    <button class="btn btn-info btn-sm" 
                        data-status="close" 
                        data-id="${item.id}"
                        id="user-${item.id}">
                            <i class="bi bi-pencil-square"></i>
                    </button>&nbsp;
                    <button class="btn btn-danger btn-sm" id="toast-failed"><i class="bi bi-trash-fill"></i></button>
                </td>
            `;
    
            fragment.appendChild(row); // Menggunakan fragmen dokumen untuk menambahkan baris
        });

        userTable.appendChild(fragment);
        createdEditButtons();
        createPaginationButtons(response.data.data, page)
    }).catch(error => {
        handleError(error)
    });
}

function getUserDetail(id){
    const newRow = document.createElement('tr');
    const rowData = document.getElementById(`row-${id}`)
    newRow.id = `form-row-${id}`
    newRow.innerHTML = `<td colspan="9" class="container">
        <div class="d-flex justify-content-center p-5">
            <div class="spinner-border text-primary text-bold" style="width: 3rem; height: 3rem;">
                <span class="sr-only"></span>
            </div>
        </div>
    </td>`
    rowData.after(newRow)
    axios.get(`/api/v1/users/${id}`, {
        headers: headers
    }).then(response => {
        const user = response.data.data
        const editBtn = document.getElementById(`user-${id}`)
        editBtn.querySelector("i").className = "bi bi-x-circle"
        newRow.innerHTML = `<td colspan="9">
            <div class="card-content">
                <div class="card-body">
                    <form class="form form-horizontal">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="first-name-horizontal">Name</label>
                                </div>
                                <div class="col-md-4 form-group">
                                    <input type="text" id="name" name+"name" value=${user.name} class="form-control" name="fname"
                                        placeholder="Name">
                                </div>
                                <div class="col-md-2">
                                    <label for="email-horizontal">Email</label>
                                </div>
                                <div class="col-md-4 form-group">
                                    <input type="email" id="email" class="form-control" name="email" value=${user.email} placeholder="Email">
                                </div>
                                <div class="col-md-2">
                                    <label for="contact-info-horizontal">Role</label>
                                </div>
                                <div class="col-md-4 form-group">
                                    <select id="role" class="form-select" name="role" value${user.role_id}>
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="password-horizontal">Status</label>
                                </div>
                                <div class="col-md-4 form-group">
                                    <select id="status" class="form-select" name="status" value${user.status}>
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                    </select>
                                </div>
                                <br>
                                <div class="col-sm-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Update</button>
                                    <button class="btn btn-light-secondary me-1 mb-1 ml-2">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </td>`;

        const userEditButton = document.getElementById(`user-${id}`);
        userEditButton.dataset.status = "open"
        rowData.after(newRow)
    }).catch(error => {
        handleError(error)
    })
}

function createdEditButtons(){
    const userEditButton = document.querySelectorAll('#user-action-button .btn-info');
    userEditButton.forEach(buttonEdit => {
        buttonEdit.addEventListener("click", function() {
            const userId = this.dataset.id;
            if(this.dataset.status == "close"){
                getUserDetail(userId)
            }else{
                this.dataset.status = "close"
                this.querySelector("i").className = "bi bi-pencil-square"
                document.getElementById(`form-row-${userId}`).innerHTML = ""
            }
        })
    })
}

function createPaginationButtons(data, page) {
    const paginationContainer = document.getElementById("users-table-pagination");
    let paginationHTML = `<li class="page-item">
        <a class="page-link" href="#" data-page="1" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
            <span class="sr-only"></span>
        </a>
    </li>`;

    for (let i = Math.max(1, page - 3); i <= Math.min(data.last_page, page + 5); i++) {
        paginationHTML += `
            <li class="page-item">
                <a class="page-link ${page == i ? 'active':''}" href="#" data-page="${i}">${i}</a>
            </li>
        `;
    }

    paginationHTML += `<li class="page-item">
        <a class="page-link" href="#" data-page="${data.last_page}" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
            <span class="sr-only"></span>
        </a>
    </li>`;

    paginationContainer.innerHTML = paginationHTML;
    paginationContainer.querySelectorAll('a.page-link').forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault(); 
            this.classList.add("active")
            document.getElementById("users-table-body").innerHTML = ''
            spinnerAction("user-table-spinner","table-row")
            const pageNumber = parseInt(this.dataset.page);
            getUser(pageNumber);
        });
    });
}

