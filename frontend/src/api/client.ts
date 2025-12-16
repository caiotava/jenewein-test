const API_URL = (window as any).__ENV__?.API_URL ?? import.meta.env.VITE_API_URL;

export type PaginatedResponse<T> = {
    items: T[];
    page: number;
    limit: number;
    total: number;
    totalPages: number;
};

export async function apiFetch<T>(
    path: string,
    options: RequestInit = {}
): Promise<T> {
    const token = localStorage.getItem("access_token");
    const res = await fetch(`${API_URL}${path}`, {
        ...options,
        headers: {
            "Accept": "application/json",
            "Content-Type": "application/json",
            ...(token ? {Authorization: `Bearer ${token}`} : {}),
            ...options.headers,
        },
    });

    if (!res.ok) {
        throw new Error(await res.text());
    }

    return res.json();
}
