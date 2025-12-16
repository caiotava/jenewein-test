import {useQuery} from "@tanstack/react-query";
import {apiFetch, type PaginatedResponse} from "@/api/client";
import {userAuth} from "@/api/userAuth";

export type Course = {
    id: number;
    name: string;
    description: string;
    contents: CourseContent[]
};

export type CourseContent = {
    id: number;
    title: string;
    description: string;
    link: string;
}

export function useCourses(page: number) {
    const {userID} = userAuth();
    return useQuery({
        queryKey: ["courses", page],
        queryFn: () =>
            apiFetch<PaginatedResponse<Course>>(`/api/users/${userID}/courses?page=${page}&limit=6`),
    });
}

export function useCourse(id: string | undefined) {
    return useQuery({
        queryKey: ["course"],
        queryFn: () =>
            apiFetch<Course>(`/api/courses/${id}`),
    });
}
