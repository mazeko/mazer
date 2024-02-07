import '../axios.min.js'
import { appKey, bearerToken } from "../pages/app.js";

function createMenuItem(item) {
    const menuList = document.createElement("li");
    const menuLink = document.createElement("a");
    const menuIcon = document.createElement("i");
    const menuName = document.createElement("span");

    menuList.classList.add("sidebar-item");
    menuLink.classList.add("sidebar-link");
    menuIcon.className = item.menu_icon;
    menuName.textContent = item.menu_title;
    menuLink.id = item.menu_id;
    if(item.submenu.length === 0){
        menuLink.href = item.menu_link;
    }

    menuLink.appendChild(menuIcon);
    menuLink.appendChild(menuName);
    menuList.appendChild(menuLink);

    menuLink.dataset.status = "closed";
    menuLink.addEventListener('click', () => toggleSubMenu(item.menu_id));

    return menuList;
}

function showSubMenu(menuId, submenu) {
    const submenuList = document.createElement("ul");
    submenuList.classList.add("submenu");
    submenuList.id = `submenu-${menuId}`;

    submenu.forEach(submenuItem => {
        const submenu = document.createElement("li");
        const submenuLink = document.createElement("a");

        submenu.classList.add("submenu-item");
        submenuLink.classList.add("submenu-link");
        submenuLink.href = submenuItem.submenu_link;
        submenuLink.textContent = submenuItem.submenu_title;

        submenu.appendChild(submenuLink);
        submenuList.appendChild(submenu);
    });

    return submenuList;
}

// Fungsi untuk mengganti status submenu
function toggleSubMenu(menuId) {
    const menuLink = document.getElementById(menuId);
    const submenu = document.getElementById(`submenu-${menuId}`);

    if (menuLink.dataset.status === "open") {
        menuLink.dataset.status = "closed";
        submenu.className = "submenu submenu-closed";
    } else {
        menuLink.dataset.status = "open";
        submenu.className = "submenu submenu-open";
    }
}

axios.get('/api/v1/menu/access', {
    headers: { 
        "MEZER-KEY" : appKey,
        "Authorization": `Bearer ${bearerToken}` 
    }
})
.then(response => {
    const sidebarMenu = document.getElementById("sidebar-menu");

    response.data.data.forEach(item => {
        const menuList = createMenuItem(item);
        
        if (item.submenu.length !== 0) {
            menuList.classList.add("has-sub");
            const submenuList = showSubMenu(item.menu_id, item.submenu);
            menuList.appendChild(submenuList);
        }

        sidebarMenu.appendChild(menuList);
    });
})
.catch(error => {
    console.error('Error: ', error);
});