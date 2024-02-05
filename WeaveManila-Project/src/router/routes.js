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
      { path: 'main-dashboard', component: () => import('pages/Owner_Module/Dashboard/MainDashboard.vue') },
      { path: 'account-settings', component: () => import('pages/Owner_Module/Dashboard/AccountSettings/AccountDashboard.vue') },
      { path: 'account-basicinfo', component: () => import('pages/Owner_Module/Dashboard/AccountSettings/AccountBasicinfo.vue') },
      { path: 'account-profilepic', component: () => import('pages/Owner_Module/Dashboard/AccountSettings/AccountUserprofile.vue') },
      { path: 'account-contactinfo', component: () => import('pages/Owner_Module/Dashboard/AccountSettings/AccountContactInfo.vue') },
      { path: 'account-changepass', component: () => import('pages/Owner_Module/Dashboard/AccountSettings/AccountSecurity.vue') },
      // Audit Logs
      { path: 'auditlogs-section', component: () => import('pages/Owner_Module/Dashboard/AuditLogs/AuditlogPage.vue') },
      // User Management
      { path: 'usermanagement-section', component: () => import('pages/Owner_Module/Dashboard/UserManagement/UserManagement.vue') },
      // Inventory Module
      { path: 'inventory-section', component: () => import('pages/Owner_Module/Dashboard/InventoryModule/InventoryPage.vue') },
      { path: 'supplier-section', component: () => import('pages/Owner_Module/Dashboard/InventoryModule/SupplierPage.vue') },

    ]
  },
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue')
  }
];

export default routes;
