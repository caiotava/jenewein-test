export function userAuth() {
    const token = localStorage.getItem("access_token");
    const userRoles = localStorage.getItem("roles");
    const userID =  localStorage.getItem("user_id");

    return {
        isAuthenticated: !!token,
        userRoles,
        isAdmin: userRoles?.includes("ROLE_ADMIN"),
        userID,
    };
}

export function login(id: string, token: string, roles: string[]) {
    localStorage.setItem("user_id", id);
    localStorage.setItem("access_token", token);
    localStorage.setItem("roles", JSON.stringify(roles));

    window.dispatchEvent(new Event("auth-change"));
}

export function logout() {
    localStorage.removeItem("user_id");
    localStorage.removeItem("access_token");
    localStorage.removeItem("roles");

    window.dispatchEvent(new Event("auth-change"));
}
