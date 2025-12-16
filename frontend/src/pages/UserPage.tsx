import {useState} from "react";
import {useUsers} from "@/api/users";
import Pagination from "@/components/pagination/pagination.tsx";

export default function OrganizationsPage() {
    const [currentPage, setCurrentPage] = useState(1);
    const {data, isLoading, isError} = useUsers(currentPage);

    if (isLoading) {
        return <p>Loading course…</p>;
    }

    if (isError || !data) {
        return <p>Failed to load course.</p>;
    }

    return (
        <div className="overflow-x-auto mt-16">
            <div className="overflow-hidden rounded-xl border border-gray-200 shadow-sm">
                <table className="w-full border-collapse text-sm">
                    <thead>
                    <tr className="bg-gray-800 text-white">
                        <th className="px-4 py-3 font-semibold">ID</th>
                        <th className="px-4 py-3 font-semibold">Name</th>
                        <th className="px-4 py-3 font-semibold">Roles</th>
                    </tr>
                    </thead>

                    <tbody className="bg-white">
                    {data.items.map(item => (
                        <tr className="border-b last:border-0 hover:bg-gray-100 transition">
                            <td className="px-1 py-3 text-gray-700">{item.id}</td>
                            <td className="px-4 py-3 font-medium text-gray-900">{item.name}</td>
                            <td className="px-4 py-3 font-medium text-gray-900">{item.roles.join(', ')}</td>
                        </tr>
                    ))}
                    </tbody>
                </table>
            </div>


            <Pagination page={data.page} totalPages={data.totalPages} onPageChange={setCurrentPage}/>
        </div>
    );
}
