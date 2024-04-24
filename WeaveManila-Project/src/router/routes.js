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
      { path: 'company-settings', component: () => import('pages/Owner_Module/Dashboard/AccountSettings/CompanySetting.vue') },
      // Audit Logs
      { path: 'auditlogs-section', component: () => import('pages/Owner_Module/Dashboard/AuditLogs/AuditlogPage.vue') },
      // User Management
      { path: 'usermanagement-section', component: () => import('pages/Owner_Module/Dashboard/UserManagement/UserManagement.vue') },

      // Inventory Module
      { path: 'inventory-section', component: () => import('pages/Owner_Module/Dashboard/InventoryModule/InventoryPage.vue') },
      { path: 'mpoform-section', component: () => import('pages/Owner_Module/Dashboard/InventoryModule/MpoForm.vue') },
      { path: 'mpo-section', component: () => import('pages/Owner_Module/Dashboard/InventoryModule/MpoPage.vue') },
      { path: 'segregator-section', component: () => import('pages/Owner_Module/Dashboard/InventoryModule/SegregatorPage.vue') },
      { path: 'supplier-section', component: () => import('pages/Owner_Module/Dashboard/InventoryModule/SupplierPage.vue') },

      // Inventory Pages
      { path: 'inventory-viewpage', component: () => import('pages/Owner_Module/Dashboard/InventoryModule/InventoryPages/ViewDetails.vue') },
      { path: 'inventory-viewlist', component: () => import('pages/Owner_Module/Dashboard/InventoryModule/InventoryPages/ViewItemlist.vue') },

      { path: 'rawmaterials-section', component: () => import('pages/Owner_Module/Dashboard/InventoryModule/InventoryPages/RawMaterials.vue') },
      { path: 'segregate-section', component: () => import('pages/Owner_Module/Dashboard/InventoryModule/InventoryPages/SegregatePage.vue') },

       // Production Monitoring Module
      { path: 'productionplan-section', component: () => import('pages/Owner_Module/Dashboard/ProductionMonitoring/ProductionPlan.vue') },
      { path: 'joborderlist-section', component: () => import('pages/Owner_Module/Dashboard/ProductionMonitoring/JoborderList.vue') },
      { path: 'joborder-section', component: () => import('pages/Owner_Module/Dashboard/ProductionMonitoring/JobOrder.vue') },
      { path: 'weaver-section', component: () => import('pages/Owner_Module/Dashboard/ProductionMonitoring/WeaverPage.vue') },

      // Supplier Pages
      { path: 'supplier-restorepoint', component: () => import('pages/Owner_Module/Dashboard/InventoryModule/SupplierPages/SupplierRestore.vue') },

      // Backup And Restore Module
      { path: 'backup-section', component: () => import('pages/Owner_Module/Dashboard/BackupAndRestore/BackupPage.vue') },
      { path: 'restore-section', component: () => import('pages/Owner_Module/Dashboard/BackupAndRestore/RestorePage.vue') },


    ]
  },
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue')
  }
];

export default routes;
