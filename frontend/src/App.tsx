import './App.css'
import {Routes, Route} from "react-router-dom";
import NavBar from "@/components/navBar";
import PageType from "@/shared/PageType";
import {RequireAuth} from "@/api/auth";
import {CoursePage, CoursesPage, IndexRedirect, LoginPage, LogoutPage, OrganizationsPage} from "@/pages";

function App() {
    return (
        <>
            <div className="app">
                <NavBar/>
                <main className="main mt-10">
                    <Routes>
                        <Route path="/" element={<IndexRedirect/>}/>
                        <Route path="/login" element={<LoginPage/>}/>

                        <Route element={<RequireAuth roles={["ROLE_USER", "ROLE_ADMIN"]}/>}>
                            <Route path={`/${PageType.Courses}`} element={<CoursesPage/>}/>
                            <Route path={`/${PageType.Courses}/:courseId`} element={<CoursePage/>}/>
                            <Route path={`/${PageType.Organizations}`} element={<OrganizationsPage/>}/>
                            <Route path={`/${PageType.Logout}`} element={<LogoutPage/>}/>
                        </Route>
                    </Routes>
                </main>
            </div>
        </>
    )
}

export default App
