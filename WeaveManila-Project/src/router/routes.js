// src/router/routes.js

const routes = [
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      { path: '', component: () => import('pages/LoginPage.vue') },
    ]
  },
  {
    path: '/forgot',
    component: () => import('layouts/ForgotLayout.vue'),
    children: [
      { path: 'reset', component: () => import('pages/PassForgot.vue') },
      { path: 'otp-verification', component: () => import('pages/OtpVerification.vue') },
      { path: 'otp-changepass', component: () => import('pages/OtpConfirmpass.vue') },
      { path: 'otp-success', component: () => import('pages/OtpSuccess.vue') },
    ]
  },
  {
    path: '/dashboard',
    component: () => import('layouts/DashboardLayout.vue'),
    children: [
      { path: 'main-dashboard', component: () => import('pages/MainDashboard.vue') },
      { path: 'account-settings', component: () => import('pages/AccountDashboard.vue') },
      { path: 'account-basicinfo', component: () => import('pages/AccountBasicinfo.vue') },
      { path: 'account-profilepic', component: () => import('pages/AccountUserprofile.vue') },


      // Add more dashboard-related routes if needed
    ]
  },
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue')
  }
];

export default routes;
