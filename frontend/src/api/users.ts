import {apiFetch, type PaginatedResponse} from "@/api/client.ts";
import {useQuery} from "@tanstack/react-query";

export type User = {
    id: number;
    name: string;
    roles: string[];
}

export function useUsers(page : number) {
    return useQuery({
        queryKey: ["users", page],
        queryFn: () =>
            apiFetch<PaginatedResponse<User>>(`/api/users?page=${page}`)
    })
}
