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
            <header className="mb-8">
                <h1 className="text-3xl font-bold mb-2">{data.name}</h1>
                <p className="text-gray-600">{data.description}</p>
            </header>

            <div>
                <h2 className="text-xl font-semibold mb-4">Course contents</h2>

                {data.contents.length === 0 ? (
                    <p className="text-gray-500">No content available for this course.</p>
                ) : (
                    <div className="space-y-3">
                        {data.contents.map(item => (
                            <div
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
                                <span className="font-bold">
                                    {item.title}
                                </span>
                                <div className="font-medium">
                                    <p>{item.description}</p>
                                </div>
                                <div className="mt-10">
                                    <a
                                        href={item.link}
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        className="inline-flex items-center justify-center
                                                   px-4 py-2
                                                   rounded-md
                                                  bg-indigo-600 text-white hover:bg-gray-800 transition"
                                    >
                                        Link
                                    </a>
                                </div>
                            </div>
                        ))}
                    </div>
                )}
            </div>
        </section>
    );
}
