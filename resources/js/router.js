import { createRouter, createWebHistory, RouterView } from 'vue-router'

/**/
import FrontSideHomePage from './frontside/Home.vue'
import Register from './frontside/Register.vue'
import Login from './frontside/Login.vue'

/**/
import Dashboard from './pages/Dashboard.vue'
import Denemelerim from './pages/Denemelerim.vue'
import Class from './pages/Class.vue'
import Student from './pages/Student.vue'
import Setting from './pages/Setting.vue'
import CreateDeneme from './pages/CreateDeneme.vue'
import DenemeAnaliz from './pages/DenemeAnaliz.vue'
import OptikForm from './pages/OptikForm.vue'
import OptikFormEdit from './pages/OptikFormEdit.vue'
import CreateOptikForm from './pages/CreateOptikForm.vue'
import UploadAnswerKey from './pages/UploadAnswerKey.vue'

/**/
import AdminLogin from './admin/Login.vue'
import AdminDashboard from './admin/Dashboard.vue'
import AdminClass from './admin/Class.vue'
import AdminStudent from './admin/Student.vue'
import Period from './admin/Period.vue'
import CreatePeriod from './admin/CreatePeriod.vue'
import Kurumlar from './admin/Kurumlar.vue'

const routes = [
  {
    path: '/',
    name: 'Home',
    component: FrontSideHomePage
    // component: () => import(/* webpackChunkName: "about" */ '../views/About.vue')
    // component: () => import('../views/About.vue')
  },
  {
    path: '/register',
    name: 'Register',
    component: Register,
    meta: {guest: true}
  },
  {
    path: '/login',
    name: 'Login',
    component: Login,
    meta: {guest: true}
  },
  {
    path: '/dashboard',
    name: 'Dashboard',
    component: Dashboard,
    meta: {requiresAuth: true}
  },
  {
    path: '/denemelerim',
    name: 'Denemelerim',
    component: Denemelerim,
    meta: {requiresAuth: true}
  },
  {
    path: '/classes',
    name: 'Class',
    component: Class,
    meta: {requiresAuth: true}
  },
  {
    path: '/students',
    name: 'Student',
    component: Student,
    meta: {requiresAuth: true}
  },
  {
    path: '/settings',
    name: 'Setting',
    component: Setting,
    meta: {requiresAuth: true}
  },
  {
    path: '/yeni-deneme',
    name: 'CreateDeneme',
    component: CreateDeneme,
    meta: {requiresAuth: true}
  },
  {
    path: '/deneme-analiz/:deneme_id',
    name: 'DenemeAnaliz',
    component: DenemeAnaliz,
    props: true,
    meta: {requiresAuth: true}
  },
  {
    path: '/upload-answerkey/:deneme_id',
    name: 'UploadAnswerKey',
    component: UploadAnswerKey,
    props: true,
    meta: {requiresAuth: true}
  },
  {
    path: '/optik-formlar',
    name: 'OptikForm',
    component: OptikForm,
    meta: {requiresAuth: true}
  },
  {
    path: '/optik-form-edit/:optik_form_id',
    name: 'OptikFormEdit',
    component: OptikFormEdit,
    props: true,
    meta: {requiresAuth: true}
  },
  {
    path: '/yeni-optik-form',
    name: 'CreateOptikForm',
    component: CreateOptikForm,
    meta: {requiresAuth: true}
  },
  {
    path: '/admin',
    component: RouterView,
    children: [
      {
        path: 'login',
        name: 'AdminLogin',
        component: AdminLogin,
        meta: {admin_login: true}
      },
      {
        path: 'dashboard',
        name: 'AdminDashboard',
        component: AdminDashboard,
        meta: {requiresAdminAuth: true}
      },
      {
        path: 'classes',
        name: 'AdminClass',
        component: AdminClass,
        meta: {requiresAdminAuth: true}
      },
      {
        path: 'students',
        name: 'AdminStudent',
        component: AdminStudent,
        meta: {requiresAdminAuth: true}
      },
      {
        path: 'periods',
        name: 'Period',
        component: Period,
        meta: {requiresAdminAuth: true}
      },
      {
        path: 'create-period',
        name: 'CreatePeriod',
        component: CreatePeriod,
        meta: {requiresAdminAuth: true}
      },
      {
        path: 'kurumlar',
        name: 'Kurumlar',
        component: Kurumlar,
        meta: {requiresAdminAuth: true}
      },
    ],
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
