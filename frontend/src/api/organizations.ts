import {apiFetch, type PaginatedResponse} from "@/api/client.ts";
import {useQuery} from "@tanstack/react-query";

export type Organization = {
    id: number;
    name: string;
}

export function useOrganizations(page : number) {
    return useQuery({
        queryKey: ["organizations", page],
        queryFn: () =>
            apiFetch<PaginatedResponse<Organization>>(`/api/organizations?page=${page}`)
    })
}
