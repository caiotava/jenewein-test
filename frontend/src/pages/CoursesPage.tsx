import {useState} from "react";
import {useCourses} from "@/api/courses";
import CourseCard from "@/components/course/card";
import Pagination from "@/components/pagination/pagination";

export default function CoursesPage() {
    const [currentPage, setPage] = useState(1);
    const {data, isLoading, isError} = useCourses(currentPage);

    if (isLoading) {
        return <p>Loading courses…</p>;
    }

    if (isError || !data) {
        return <p>Failed to load courses.</p>;
    }

    return (
        <section className="max-w-6xl mx-auto px-4">
            <h1 className="text-3xl font-bold mb-6 pt-4">Your Courses</h1>

            {data.items.length === 0 ? (
                <p>No courses available.</p>
            ) : (
                <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                    {data.items.map(course => (
                        <CourseCard id={course.id} name={course.name} description={course.description}/>
                    ))}
                </div>
            )}

            <Pagination page={data.page} totalPages={data.totalPages} onPageChange={setPage} />
        </section>
    );
}
