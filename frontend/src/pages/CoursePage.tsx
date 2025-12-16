import {useParams} from "react-router-dom";
import {useCourse} from "@/api/courses";

export default function CourseDetailPage() {
    const {courseId} = useParams<{ courseId: string }>();

    const {data, isLoading, isError} = useCourse(courseId);

    if (isLoading) {
        return <p>Loading course…</p>;
    }

    if (isError || !data) {
        return <p>Failed to load course.</p>;
    }

    return (
        <section className="max-w-4xl mx-auto px-4">
            {/* Course header */}
            <header className="mb-8">
                <h1 className="text-3xl font-bold mb-2">
                    {data.name}
                </h1>

                {data.description && (
                    <p className="text-gray-600">
                        {data.description}
                    </p>
                )}
            </header>

            {/* Course contents */}
            <div>
                <h2 className="text-xl font-semibold mb-4">
                    Course contents
                </h2>

                {data.contents.length === 0 ? (
                    <p className="text-gray-500">
                        No content available for this course.
                    </p>
                ) : (
                    <ul className="space-y-3">
                        {data.contents.map(item => (
                            <li
                                key={item.id}
                                className="
                  bg-white
                  border
                  rounded-lg
                  p-4
                  hover:bg-rose-50
                  transition
                "
                            >
                <span className="font-medium">
                  {item.title}
                </span>
                            </li>
                        ))}
                    </ul>
                )}
            </div>
        </section>
    );
}
