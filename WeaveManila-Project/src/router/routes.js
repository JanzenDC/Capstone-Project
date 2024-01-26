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
      { path: 'reset', component: () => import('pages/password_recovery/PassForgot.vue') },
      { path: 'otp-verification', component: () => import('pages/password_recovery/OtpVerification.vue') },
      { path: 'otp-changepass', component: () => import('pages/password_recovery/OtpConfirmpass.vue') },
      { path: 'otp-success', component: () => import('pages/password_recovery/OtpSuccess.vue') },
    ]
  },
  {
    path: '/dashboard',
    component: () => import('layouts/DashboardLayout.vue'),
    children: [
      { path: 'main-dashboard', component: () => import('pages/Dashboard/MainDashboard.vue') },
      { path: 'account-settings', component: () => import('pages/Dashboard/AccountDashboard.vue') },
      { path: 'account-basicinfo', component: () => import('pages/Dashboard/AccountBasicinfo.vue') },
      { path: 'account-profilepic', component: () => import('pages/Dashboard/AccountUserprofile.vue') },
      { path: 'account-contactinfo', component: () => import('pages/Dashboard/AccountContactInfo.vue') },
      { path: 'account-changepass', component: () => import('pages/Dashboard/AccountSecurity.vue') },
      // Audit Logs
      { path: 'auditlogs-section', component: () => import('pages/Dashboard/AuditLogs/AuditlogPage.vue') },
      // User Management
      { path: 'usermanagement-section', component: () => import('pages/Dashboard/UserManagement/UserManagement.vue') },
    ]
  },
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue')
  }
];

export default routes;
