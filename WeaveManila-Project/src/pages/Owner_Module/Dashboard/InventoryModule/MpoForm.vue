<template>
<q-drawer
show-if-above
v-model="drawer"
side="left"
bordered
:width="drawerWidth">
  <ul class=" p-2 flex flex-col h-full static" v-if="drawerWidth !== 80">
    <div class="flex">
      <div class="w-1/4 items-center flex justify-center" >
        <q-img
          src="../../../../assets/favicon-128x128.png"
          alt="Description of the image"
          class="w-[50px] md:w-[60px]"
        />
      </div>
      <div class=" items-center flex justify-center" v-if="drawerWidth <= 80">
        <q-img
          src="../../../../assets/favicon-128x128.png"
          alt="Description of the image"
          class="w-[150px] md:w-[60px]"
        />
      </div>
      <div class="text-[#281c0f] text-[18px] w-3/4 flex justify-center items-center gap-1" v-if="drawerWidth !== 80">
      <div>
        <span class="font-bold ">WEAVEMANILA INC.</span><br>
      </div>
      <div>
        <q-icon name="keyboard_double_arrow_right" class="text-[30px] cursor-pointer" @click="toggleDrawer" />
      </div>
    </div>

    </div>



    <li class="font-bold mt-5">Menu</li>
      <li class="py-[10px] px-[20px]" >
        <div class="flex items-center">
          <router-link to="/dashboard/main-dashboard">
          <q-icon name="dashboard" class="mr-2" /> <span >Dashboard</span>
          </router-link>
        </div>
      </li>

      <li class="py-[10px] px-[20px]" @click="toggleInventoryMenu">
        <div class="flex items-center gap-2 justify-between">
          <div><q-icon name="inventory"/> <span >Inventory</span></div>
          <div><q-icon name="expand_more"  /> </div>
        </div>
        <ul v-if="inventoryMenuVisible">
          <router-link to="/dashboard/inventory-section">
            <li class="py-[2px] px-[40px] mt-3">Materials</li>
          </router-link>
          <router-link to="/dashboard/mpoform-section">
            <li class="px-[40px] mt-3"> Material Purchase Order</li>
          </router-link>
        </ul>
      </li>

      <li class="py-[10px] px-[20px]" @click="toggleProduction">
        <div class="flex items-center gap-2 justify-between">
          <div>
            <i class="bi bi-box-seam"></i> <span >Product Monitoring</span>
          </div>
          <div><q-icon name="expand_more"  /> </div>
        </div>
        <ul v-if="productionVisible">
          <router-link to="/dashboard/productionplan-section">
            <li class="py-[2px] px-[40px] mt-3">Production Plan</li>
          </router-link>
          <router-link to="/dashboard/joborder-section">
            <li class="px-[40px] mt-3">Job Order</li>
          </router-link>
        </ul>
      </li>
      <li class="py-[10px] px-[20px]">
        <div class="flex items-center">
          <q-icon name="assignment_add" class="mr-2"/><span>Report</span>
        </div>
      </li>
      <!-- Settings Section -->
      <li class="font-bold" >Admin</li>
      <li class="py-[10px] px-[20px]">
        <div class="flex items-center">
          <router-link to="/dashboard/auditlogs-section">
            <i class="bi bi-activity mr-2"></i> <span >Audit Logs</span>
          </router-link>
        </div>
      </li>
      <li class="py-[10px] px-[20px]">
        <div class="flex items-center">
          <router-link to="/dashboard/usermanagement-section">
            <q-icon name="group" class="mr-2"/> <span >User Management</span>
          </router-link>
        </div>
      </li>
      <li class="py-[10px] px-[20px]">
        <div class="flex items-center">
          <router-link to="/dashboard/account-settings">
            <q-icon name="manage_accounts" class="mr-2"/> <span >Account Settings</span>
          </router-link>
        </div>
      </li>
      <li class="py-[10px] px-[20px]" v-if="isAdmin === 1">
        <div class="flex items-center">
          <router-link to="/dashboard/backup-section">
            <q-icon name="backup" class="mr-2"/> <span >Data Backup</span>
          </router-link>
        </div>
      </li>

      <li class="mt-auto py-[10px]">
        <q-separator />
        <div class="flex justify-between text-center" >
          <div class="flex items-center" >
            <q-img
              :src="getUserProfileImagePath()"
              alt="Description of the image"
              class="w-12 md:w-12 rounded-full"
            />
            <div class="ml-2 overflow-hidden">
              <div class="whitespace-nowrap overflow-hidden text-overflow-ellipsis font-bold">
                {{ getLimitedFullname(fullname, 25) }}
              </div>
              <div class="text-center">
                {{ position }}
              </div>
            </div>
          </div>
          <div class="flex items-center ">
            <div @click="OpenLogout = true">
              <q-icon name="logout" class="h-[18px] w-[20px] font-bold"/>
            </div>
          </div>
        </div>
      </li>
  </ul>

  <ul class="p-2 flex flex-col h-full static" v-if="drawerWidth <= 80">

    <div class="flex justify-center items-center text-[40px]">
      <div class=" items-center flex justify-center cursor-pointer" v-if="drawerWidth <= 80">
        <q-icon name="keyboard_double_arrow_right" @click="toggleDrawer"/>
      </div>
    </div>

      <li class="mt-5 text-center">Menu</li>
      <li class="py-[10px] px-[20px]" >
        <div class="flex items-center" @click="toggleDrawer">
          <q-icon name="dashboard" />
        </div>
      </li>
      <!-- Process Section -->

      <li class="py-[10px] px-[20px]" @click="toggleDrawer">
        <div class="flex items-center gap-2 justify-between">
          <div><q-icon name="inventory"/></div>
        </div>
      </li>

      <li class="py-[10px] px-[20px] ">
        <div class="flex items-center gap-2" @click="toggleDrawer">
          <i class="bi bi-box-seam"></i>
        </div>
      </li>
      <li class="py-[10px] px-[20px]">
        <div class="flex items-center" @click="toggleDrawer">
          <q-icon name="description" />
        </div>
      </li>
      <li class="text-center">Admin</li>
      <li class="py-[10px] px-[20px]">
        <div class="flex items-center" @click="toggleDrawer">
            <i class="bi bi-activity"></i>
        </div>
      </li>
      <li class="py-[10px] px-[20px]">
        <div class="flex items-center" @click="toggleDrawer">
            <q-icon name="group" class="mr-2"/>
        </div>
      </li>
      <li class="py-[10px] px-[20px]">
        <div class="flex items-center" @click="toggleDrawer">
            <q-icon name="manage_accounts"/>
        </div>
      </li>
      <li class="py-[10px] px-[20px]">
        <div class="flex items-center" @click="toggleDrawer">
            <q-icon name="backup"/>
        </div>
      </li>


      <li class="mt-auto py-[10px]">
          <div class="flex justify-center ">
            <div @click="OpenLogout = true">
              <q-icon name="logout" class="h-[18px] w-[20px] font-bold"/>
            </div>
          </div>
      </li>
  </ul>
</q-drawer>
<q-page class="bg-[#f5f5f5] ">
  <div class="text-[30px] bg-white p-2 ">
    <div class="items-center flex">
      <q-icon
        name="menu"
        v-if="showMenuIcon"
        @click="toggleDrawer"
        class="cursor-pointer"
      />
      <q-icon
        name="menu"
        v-if="!showMenuIcon"
        @click="toggleDrawer"
        class="cursor-pointer max-[1020px]:flex min-[1020px]:hidden"
      />
    <span class="font-bold">Material Purchase Order</span>
    </div>
    <div class="text-[16px]"><span class="text-[#b8b8b8]">Inventory / </span>Material Purchase Order</div>
  </div>

  <div class="p-4">
    <!-- Header -->
    <div class="flex mt-3">
      <router-link to="/dashboard/mpo-section">
        <div class="flex bg-white w-[155px] border-r-2 h-[44px] py-3 px-5 gap-[8px] rounded items-center text-[14px]">
        <q-icon name="note_add"/>
        <p>MPO Form</p>
      </div>
    </router-link>
    <router-link to="/dashboard/mpo-section">
      <div class="flex w-[155px] text-[#b8b8b8] border-t-2 border-e-2 h-[44px] py-3 px-5 gap-[8px] rounded items-center text-[14px]">
        <q-icon name="list"/>
        <p>Purchase list</p>
      </div>
    </router-link>
    <router-link to="/dashboard/supplier-section">
      <div class="flex w-[155px] text-[#b8b8b8] border-t-2 border-e-2 h-[44px] py-3 px-5 gap-[8px] rounded items-center text-[14px]">
          <q-icon name="group"/>
          <p>Supplier List</p>
        </div>
    </router-link>
    </div>

    <div class="w-full bg-white p-4 h-[470px] overflow-x-hidden overflow-y-auto">
     <q-form @submit="sendingForm">
        <div>
                <label>Category</label>
                <q-select
                  v-model="selectedCategory"
                  :options="categories"
                  emit-value
                  map-options
                  outlined
                  dense
                  class="w-[230px]"
                  lazy-rules
                  :rules="SelectionRules"
                />
        </div>
        <p class="text-[24px] font-semibold mb-8">Material Purchase Order</p>

        <div class="flex">
          <div class="w-1/4">
              <div>
                <label>MPO Ref. No</label>
                <q-input dense outlined v-model="mpo_ref" class="w-[230px]" disable lazy-rules :rules="[ val => val && val.length > 0 || 'Please input something']"/>
              </div>

              <div>
                <label>Date Purchased</label>
                <q-input dense outlined v-model="date_purchased" type="date" class="w-[230px]" lazy-rules :rules="[ val => val && val.length > 0 || 'Please input something']"/>
              </div>

              <div>
                <label>Client Ref. NO.</label>
                <q-input dense outlined v-model="client_ref" class="w-[230px]"/>
              </div>

              <div class="mt-5">
                <label>W.O Ref. No.</label>
                <q-input dense outlined v-model="wo_purchased" class="w-[230px]"/>
              </div>

              <div class="mt-5">
                <label>Delivery Date</label>
                <q-input dense outlined v-model="delivery_date_val" type="date" class="w-[230px]" lazy-rules :rules="[ val => val && val.length > 0 || 'Please input something']"/>
              </div>
          </div>
          <div class="w-3/4">
            <div class="flex justify-center items-center h-[250px]">
              <q-img
                :src="previewLogo || defaultImageLogo()"
                alt="Description of the image"
                class="w-[930px] max-h-[250px]"
              />
            </div>

            <div class="flex items-center gap-2 mt-3">
              <q-input v-model="uploadedFileName" outlined dense label="Logo" disabled />
              <q-btn @click="triggerFileInput('logo')" class="text-white bg-[#634832]">Change Photo</q-btn>
              <input ref="logoInput" type="file" style="display: none" @change="handleFileChange('logo', $event)">
            </div>

            <div class="mt-5">
                <label>Company Address</label>
                <q-input v-model="company_address" dense disable outlined class="w-full" lazy-rules :rules="[ val => val && val.length > 0 || 'Please input something']">
                  <template v-slot:after>
                    <q-icon name="edit" class="cursor-pointer" @click="openCompany = true"/>
                  </template>
                </q-input>
            </div>
          </div>
        </div>
        <!-- Deliver Area -->
        <div>
          <label>Delivery Address</label>
          <q-input dense outlined v-model="delivery_add_val"  class="w-full" disable lazy-rules :rules="[ val => val && val.length > 0 || 'Please type something']">
            <template v-slot:after>
              <q-icon name="edit" class="cursor-pointer" @click="openDelivery = true"/>
            </template>
          </q-input>
        </div>
        <!-- Supplier Area -->
        <label class="text-h6 font-bold">To:</label>
        <div class="flex">
          <div class="w-1/4">
              <label>Supplier</label>
              <q-select
                v-model="selectedSupplier"
                :options="supplier_list"
                emit-value
                map-options
                outlined
                dense
                class="w-[230px]"
                lazy-rules :rules="SelectionRules"
              />
          </div>
          <div class="w-3/4">
            <label>Supplier Address</label>
            <q-input dense outlined v-model="supplier_address" disable class="w-full" lazy-rules :rules="[ val => val && val.length > 0 || 'Please input something']"/>
          </div>
        </div>
        <!-- Process -->
        <label class="text-h6 font-bold">Process:</label>
        <div class="grid grid-cols-4 gap-5">
          <div>
            <label>Segregation</label>
            <q-input dense outlined v-model="segregation" class="w-[230px]"/>
          </div>
          <div>
            <label>Cleaning</label>
            <q-input dense outlined v-model="cleaning" class="w-[230px]"/>
          </div>
          <div>
            <label>Drying</label>
            <q-input dense outlined v-model="drying" class="w-[230px]"/>
          </div>
          <div>
            <label>Weighting</label>
            <q-input dense outlined v-model="weighting" class="w-[230px]"/>
          </div>
        </div>
        <!-- Add Product -->
        <div>
          <div class="q-pa-md">
            <div class="mb-3 flex items-center justify-end">
              <q-btn label="Add Product" icon="add" class="bg-[#634832] text-white" @click="addProduct" />
            </div>

            <q-table
              dense bordered
              :rows="datarows"
              :columns="datacolumns"
              row-key="name"
              :pagination="initialPagination"
              no-data-label="Please provide the necessary data to continue."
              class="my-sticky-header-table-second"
            >

            <template v-slot:body="props">
              <q-tr :props="props">
                <q-td key="id" :props="props">
                  {{ props.row.id }}
                </q-td>
                <q-td key="sproduct" :props="props">
                  <template v-if="selectedCategory === 'Raw Materials'">
                    {{ props.row.sproduct }}
                    <q-popup-edit v-model="props.row.sproduct" title="Update Product" buttons v-slot="scope">
                      <q-select
                        v-model="scope.value"
                        :options="rawMaterialsOptions"
                        outlined
                        dense
                        autofocus
                      />
                    </q-popup-edit>
                  </template>
                  <template v-else>
                    {{ props.row.sproduct }}
                    <q-popup-edit v-model="props.row.sproduct" title="Update Product" buttons v-slot="scope">
                      <q-input type="text" v-model="scope.value" dense autofocus />
                    </q-popup-edit>
                  </template>
                </q-td>

                <q-td key="sdescription" :props="props">
                  {{ props.row.sdescription }}
                  <q-popup-edit v-model="props.row.sdescription" title="Update Description" buttons v-slot="scope">
                    <q-input type="text" v-model="scope.value" dense autofocus />
                  </q-popup-edit>
                </q-td>
                <q-td key="squantity" :props="props">
                  {{ props.row.squantity }}
                  <q-popup-edit v-model="props.row.squantity" title="Update Quantity" buttons v-slot="scope">
                    <q-input type="number" v-model="scope.value" dense autofocus />
                  </q-popup-edit>
                </q-td>
                <q-td key="sunit" :props="props">
                  {{ props.row.sunit }}
                  <q-popup-edit v-model="props.row.sunit" title="Update Unit" buttons v-slot="scope">
                    <q-select
                        v-model="scope.value"
                        :options="unitOptions"
                        outlined
                        dense
                        autofocus
                      />
                  </q-popup-edit>
                </q-td>
                <q-td key="sunitprice" :props="props">
                  {{ props.row.sunitprice }}
                  <q-popup-edit v-model="props.row.sunitprice" title="Update Unit Price" buttons v-slot="scope">
                    <q-input type="number" v-model="scope.value" dense autofocus />
                  </q-popup-edit>
                </q-td>
                <q-td key="sdiscount" :props="props">
                  {{ props.row.sdiscount }}
                  <q-popup-edit v-model="props.row.sdiscount" title="Update Discount" buttons v-slot="scope">
                    <q-input type="number" v-model="scope.value" dense autofocus />
                  </q-popup-edit>
                </q-td>
                <q-td key="stotal" :props="props">
                  ₱ {{ computeTotal(props.row) }}
                </q-td>
                <q-td key="sactions" :props="props">
                  <q-icon name="delete" @click="deleteRow(props.row.id)" class="cursor-pointer p-2 bg-red text-white"/>
                </q-td>
              </q-tr>
            </template>
            </q-table>
            <div class="flex items-center mt-6">
              <div class="w-1/2 -mt-[90px]">
                <label>Notes & Instruction<span class="text-red-600">*</span></label>

                <q-input
                  type="textarea"
                  v-model="notes_instructions"
                  outlined
                  :maxlength="120"
                  class="w-full h-[128px] resize-none"
                >
                </q-input>
                <span class="mt-3 text-sm text-gray-400 flex justify-end">{{ characterCount }}/120 characters</span>
              </div>
              <div class="w-1/2 flex justify-end">
                <div class="grid grid-cols-2 gap-1 w-[332px] text-[16px] ">
                  Delivery Charge
                  <q-input dense outlined v-model="deliver_charge" >
                    <template v-slot:append>
                      ₱
                    </template>
                  </q-input> <!--base on user input-->
                  Other Costs
                  <div clas='flex grid-cols-2 grid'>
                    <div class='w-1/2'>
                      <q-select v-model="selectedOptions" :options="addorless" dense outlined />
                    </div>
                    <div class='w-1/2'>
                      <q-input dense outlined v-model="other_cost">
                        <template v-slot:append>
                          ₱
                        </template>
                      </q-input> <!--base on user input-->
                    </div>
                  </div>

                  Sub total
                  <q-input dense outlined v-model="total_in_table" disable>
                    <template v-slot:append>
                      ₱
                    </template>
                  </q-input>
                  Discount
                  <q-input dense outlined v-model="discount">
                    <template v-slot:append>
                      ₱
                    </template>
                  </q-input> <!--substraction automatic 10%-->
                  Vat
                  <q-input dense outlined v-model="vat" >
                    <template v-slot:append>
                      ₱
                    </template>
                  </q-input><!--substraction automatic 12%-->

                  Total Amount
                  <q-input dense outlined v-model="total_amount" disable/>
                </div>
              </div>
            </div>

            <div class="flex gap-2">
              <div>
                <label>Upload E-signature</label>
                <div class="flex items-center gap-2 mt-3 ">
                  <q-input v-model="uploadPreparedName" outlined dense label="Prepared By" disable />
                  <q-btn @click="triggerFileInput('prepared')" class="text-white bg-[#634832]">Change Photo</q-btn>
                  <input ref="preparedInput" type="file" style="display: none" @change="handleFileChange('prepared', $event)">
                </div>
                <label class="mt-3">Prepared By:</label>
                <q-input v-model="prepared_name" dense outlined lazy-rules :rules="[ val => val && val.length > 0 || 'Please input something']"/>
              </div>
              <div>
                <label>Upload E-signature</label>
                <div class="flex items-center gap-2 mt-3">
                  <q-input v-model="uploadApproveName" outlined dense label="Approved By" disable />
                  <q-btn @click="triggerFileInput('approve')" class="text-white bg-[#634832]">Change Photo</q-btn>
                  <input ref="approveInput" type="file" style="display: none" @change="handleFileChange('approve', $event)">
                </div>
                <label class="mt-3">Approved By:</label>
                <q-input v-model="approvedby_name" dense outlined lazy-rules :rules="[ val => val && val.length > 0 || 'Please input something']"/>
              </div>
            </div>
          </div>
        </div>

        <div class="justify-end flex mt-3 gap-3 ">
              <q-btn label="Save" type="submit" class="bg-[#634832] rounded-md text-white"/>
        </div>
      </q-form>
    </div>
  </div>

<!-- MODAL COMPANY ADDRESS -->
<q-dialog
  v-model="openCompany"
>
  <q-card style="width: 700px;">
    <q-card-section class="row items-center q-pb-none">
          <div class="flex items-center gap-2">
            <q-icon name="apartment" class="text-[18px] p-2"/>
            <div class="text-h6">
            Company Address
            </div>
          </div>
          <q-space />
          <q-btn icon="close" flat round dense v-close-popup />
    </q-card-section>

    <q-card-section class="q-pt-none">
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label>Region<span class="text-red-600">*</span></label>
          <q-select v-model="selectedRegion" :options="regionOptions" label="Region" @input="onRegionChange" dense outlined class='flex-wrap' />
        </div>
        <div>
          <label>Province<span class="text-red-600">*</span></label>
          <q-select v-model="selectedProvince" :options="provinceOptions" label="Province" dense outlined :disable="!selectedRegion" class='flex-wrap'/>
        </div>
        <div>
          <label>City<span class="text-red-600">*</span></label>
          <q-select v-model="selectedCity" :options="cityOptions" label="City" dense outlined :disable="!selectedProvince" class='flex-wrap'/>
        </div>
        <div>
          <label>Barangay<span class="text-red-600">*</span></label>
          <q-select v-model="selectedBarangay" :options="barangayOptions" label="Barangay" dense outlined :disable="!selectedCity" />
        </div>
      </div>
    </q-card-section>

    <q-card-actions align="right" class="bg-white text-teal">
      <q-btn flat label="Save" v-close-popup />
    </q-card-actions>
  </q-card>
</q-dialog>
<!-- End of Company Address -->

<!-- MODAL DELIVERY ADDRESS -->
<q-dialog
  v-model="openDelivery"
>
  <q-card style="width: 700px;">
    <q-card-section class="row items-center q-pb-none">
          <div class="flex items-center gap-2">
            <q-icon name="apartment" class="text-[18px] p-2"/>
            <div class="text-h6">
            Delivery Address
            </div>
          </div>
          <q-space />
          <q-btn icon="close" flat round dense v-close-popup />
    </q-card-section>

    <q-card-section class="q-pt-none">
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label>Region<span class="text-red-600">*</span></label>
          <q-select v-model="RegionDeliverySelected" :options="regionOptions" label="Region" @input="onUserRegionSelect" dense outlined class='flex-wrap' />
        </div>
        <div>
          <label>Province<span class="text-red-600">*</span></label>
          <q-select v-model="ProvinceDeliverySelected" :options="provinceOptions" label="Province" dense outlined :disable="!RegionDeliverySelected" class='flex-wrap'/>
        </div>
        <div>
          <label>City<span class="text-red-600">*</span></label>
          <q-select v-model="CityDeliverySelected" :options="cityOptions" label="City" dense outlined :disable="!ProvinceDeliverySelected" class='flex-wrap'/>
        </div>
        <div>
          <label>Barangay<span class="text-red-600">*</span></label>
          <q-select v-model="BaranggayDeliverySelected" :options="barangayOptions" label="Barangay" dense outlined :disable="!CityDeliverySelected" />
        </div>
      </div>
    </q-card-section>

    <q-card-actions align="right" class="bg-white text-teal">
      <q-btn flat label="Save" v-close-popup />
    </q-card-actions>
  </q-card>
</q-dialog>
<!-- End of Delivery Address -->
<q-dialog v-model="OpenLogout">
  <q-card class="w-[500px]">
    <q-card-section class="gap-3 items-center q-pb-none flex">
      <div class="py-1 px-2 border text-[24px]"><q-icon name="logout"/></div>
      <div class="text-h6 font-bold">Logout</div>
      <q-space />
    </q-card-section>

    <q-card-section>

      <p>Are you sure you want to Logout?</p>
    </q-card-section>

    <q-card-actions class="flex justify-center items-center">
      <div class="w-1/2 p-1">
        <q-btn flat label="Cancel" outline v-close-popup class="w-full border"/>
      </div>
      <div class="w-1/2 p-1">
        <q-btn
          @click="logout"
          flat
          label="Logout"
          size="md"
          class="bg-red-600 text-white rounded w-full"
        />
      </div>
    </q-card-actions>
  </q-card>
</q-dialog>

</q-page>
</template>

<script>

import { SessionStorage } from 'quasar';
import axios from 'axios';

import jsPDF from 'jspdf';
import html2canvas from 'html2canvas';
import philippineData from '../../../../javascript/philippine_provinces_cities_municipalities_and_barangays_2019v2.json';

export default {
  data() {
    return {
      isAdmin: 0,
      email: '',
      fullname: '',
      firstname: '',
      middlename: '',
      lastname: '',
      userProfileImage: null,
      username: '',
      position: '',
      status: '',
      drawer: false,
      showMenuIcon: false,
      statusCheckTimer: null,
      toggleDrawers: true,
      drawerWidth: 300,
      drawerIcon: 'arrow_back_ios',
      inventoryMenuVisible: false,
      productionVisible: false,
      OpenLogout: false,
      // Additional Data
      columns : [
        { name: 'mpo_number', align: 'left', label: 'MPO No.', field: 'mpo_number', sortable: true },
        { name: 'supplier', align: 'left', label: 'Supplier', field: 'supplier', sortable: true },
        { name: 'product', align: 'left', label: 'Product', field: 'product', sortable: true },
        { name: 'date_purchase', align: 'left', label: 'Date Purchase', field: 'date_purchase', sortable: true },
        { name: 'qty', align: 'left', label: 'Qty', field: 'qty', sortable: true },
        { name: 'qty_recieved', align: 'left', label: 'Qty Recieved', field: 'qty_recieved', sortable: true },
        { name: 'amount', align: 'left', label: 'Amount', field: 'amount', sortable: true },
        { name: 'status', align: 'left', label: 'Status', field: 'status', sortable: true },
        { name: 'actions', align: 'left', label: 'Actions', field: 'actions', sortable: true },
      ],
      rows: [],
      selected: [],

      // First Process Data
      company_address: '',
      mpo_ref: '',
      date_purchased: '',
      selectedCategory: '',
      categories: [],
      client_ref: '',
      wo_purchased: '',
      delivery_date_val: '',
      delivery_add_val: '',

      selectedSupplier: '',
      supplier_list: [],
      supplier_address: '',

      segregation: '',
      cleaning: '',
      drying: '',
      weighting: '',

      // Second Process Data
      datacolumns: [
        { name: 'id', align: 'left', label: '#', field: 'id', sortable: true },
        { name: 'sproduct', align: 'left', label: 'Product', field: 'sproduct', sortable: true },
        { name: 'sdescription', align: 'left', label: 'Description', field: 'sdescription', sortable: true },
        { name: 'squantity', align: 'left', label: 'Quantity', field: 'squantity', sortable: true },
        { name: 'sunit', align: 'left', label: 'Unit', field: 'sunit', sortable: true },
        { name: 'sunitprice', align: 'left', label: 'Unit Price', field: 'sunitprice', sortable: true },
        { name: 'stotal', align: 'left', label: 'Sub Total', field: 'stotal', sortable: true },
        { name: 'sactions', align: 'left', label: 'Actions', field: 'sactions', sortable: true },
      ],
      datarows: [],
      initialPagination: {
        page: 1,
        rowsPerPage: 5
      },
      deliver_charge: 0,
      discount: 0,
      vat: 0,
      other_cost: 0,
      total_amount: 0,
      total_in_table: 0,
      // THIRD PROCESS
      notes_instructions: '',
      characterCount: 0,
      approvedby_name: '',
      prepared_name: '',


      pdfData: '',
      MpoIDValue: '',
      rawMaterialsOptions: [
        'JK Fiber', 'M1 Fiber', 'S2 Fiber', 'S3 Fiber', 'G Fiber'
      ],
      unitOptions: [
        'Kilogram','Liter','Box','Rim','Rolls','Drum','Bundles','Bag','CBY','Sacks'
      ],
      // philippineData json
      philippineData: philippineData,
      // DIALOG PROPERTIES
      openCompany: false,
      openDelivery: false,
      // Picture Properties
      uploadedFileName: null,
      uploadPreparedName: null,
      uploadApproveName: null,
      previewLogo: null,
      e_signatureP: null,
      e_signatureA: null,
      uploadPhoto: null,

      // Location Data
      selectedRegion: null,
      selectedProvince: null,
      selectedCity: null,
      selectedBarangay: null,
      regionOptions: [],
      provinceOptions: [],
      cityOptions: [],
      barangayOptions: [],
      RegionDeliverySelected: null,
      ProvinceDeliverySelected: null,
      CityDeliverySelected: null,
      BaranggayDeliverySelected: null,

      //
      addorless: ['add', 'less'],
      selectedOptions: 'less',
    };
  },
  mounted() {
    this.regionOptions = Object.keys(this.philippineData)
    .map(regionCode => ({
      label: /^(0[1-9]|1[0-3]|[4][A-B]|[1-3]?[0-9])$/.test(regionCode) ? `Region ${regionCode}` : regionCode,
      value: regionCode
    }))
    .sort((a, b) => a.label.localeCompare(b.label));
    this.loadUserData();
    this.fetchMPOdata();
    this.statusCheckTimer = setInterval(() => {
      this.checkUserStatus();
    }, 20 * 1000); // 1 second (in milliseconds)
    this.fetchCategoryData();
    this.fetchSupplierData();
    this.datarows.push(
    {
      id: 1,
      sproduct: '',
      sdescription: '',
      squantity: '',
      sunit: '',
      sunitprice: '',
      sdiscount: '',
      stotal: '',
    });
  },
  watch: {
    datarows: {
      handler: function(newRows, oldRows) {
        this.updateTotalAmount();
      },
      deep: true // This ensures that changes to nested properties in datarows are detected
    },
    deliver_charge: 'updateTotalAmount',
    discount: 'updateTotalAmount',
    vat: 'updateTotalAmount',
    other_cost: 'updateTotalAmount',

    notes_instructions(newValue) {
      this.characterCount = newValue.length;
    },
    selectedCategory: {
      immediate: true // to call it on component mount
    },
    selectedSupplier(newValue) {
      if (newValue) {
        this.fetchSupplierAddress(newValue);
      }
    },
    selectedRegion: function(newValue, oldValue) {
      if (newValue !== oldValue) {
        this.onRegionChange();
      }
    },
    selectedProvince: function(newValue, oldValue) {
      if (newValue !== oldValue) {
        this.onProvinceChange();
      }
    },
    selectedCity: function(newValue, oldValue) {
      if (newValue !== oldValue) {
        this.onCityChange();
      }
    },
    selectedBarangay: function(newValue, oldValue) {
      if (newValue !== oldValue) {
        this.onBaranggayChange();
      }
    },

    RegionDeliverySelected: function(newValue, oldValue) {
      if (newValue !== oldValue) {
        this.onUserRegionSelect();
      }
    },
    ProvinceDeliverySelected: function(newValue, oldValue) {
      if (newValue !== oldValue) {
        this.onUserProvinceSelect();
      }
    },
    CityDeliverySelected: function(newValue, oldValue) {
      if (newValue !== oldValue) {
        this.onUserCitySelect();
      }
    },
    BaranggayDeliverySelected: function(newValue, oldValue) {
      if (newValue !== oldValue) {
        this.onUserBarangaySelect();
      }
    },
    date_purchased(newValue, oldValue) {
      if (newValue !== oldValue) {
        this.fetchMPOdata();
      }
    }
  },
  computed: {
    SelectionRules() {
      return [
        (val) => !!val || 'Please select a category'
      ];
    },
  },
  beforeUnmount() {
    clearInterval(this.statusCheckTimer);
  },
  methods: {
    generatePDF() {
      const pdf = new jsPDF();
      const content = document.getElementById('content');

      // Use html2canvas to render HTML to canvas
      html2canvas(content).then(canvas => {
        // Convert canvas to base64 image data
        const imgData = canvas.toDataURL('image/jpeg');

        const pageWidth = 210; // A4 width in mm
        const pageHeight = 297; // A4 height in mm

        const imgWidth = pageWidth;
        const imgHeight = (canvas.height * pageWidth) / canvas.width;


        let position = 0;
        if (imgHeight > pageHeight) {

          pdf.addPage();
          position = -pageHeight;

          pdf.addImage(imgData, 'JPEG', 0, position, imgWidth, imgHeight);
        } else {
          pdf.addImage(imgData, 'JPEG', 0, 0, imgWidth, imgHeight);
        }

        while (position + pageHeight < imgHeight) {
          position += pageHeight;
          pdf.addPage();
          pdf.addImage(imgData, 'JPEG', 0, -position, imgWidth, imgHeight);
        }

        // Save PDF
        pdf.save('document.pdf');
        // this.pdfData = pdf.output('blob');
        // console.log("PDF Data",this.pdfData);
      });
    },
    sendingForm() {
      const formData = new FormData();

      formData.append('personnel_Email', this.email);
      formData.append('company_address', this.company_address);
      formData.append('uploadPhoto', this.uploadPhoto);
      formData.append('mpo_ref', this.MpoIDValue);
      formData.append('date_purchased', this.date_purchased);
      formData.append('selectedCategory', this.selectedCategory);
      formData.append('client_ref', this.client_ref);
      formData.append('wo_purchased', this.wo_purchased);
      formData.append('delivery_date_val', this.delivery_date_val);
      formData.append('delivery_add_val', this.delivery_add_val);
      formData.append('selectedSupplier', this.selectedSupplier);
      formData.append('supplier_address', this.supplier_address);
      formData.append('segregation', this.segregation);
      formData.append('cleaning', this.cleaning);
      formData.append('drying', this.drying);
      formData.append('weighting', this.weighting);
      formData.append('deliver_charge', this.deliver_charge);
      formData.append('discount', this.discount);
      formData.append('vat', this.vat);
      formData.append('other_cost', this.other_cost);
      formData.append('total_amount', this.total_amount);
      formData.append('total_in_table', this.total_in_table);
      formData.append('notes_instructions', this.notes_instructions);
      formData.append('prepareSig', this.prepared_name);
      formData.append('approveSig', this.approvedby_name);
      formData.append('uploadPreparedName', this.e_signatureP);
      formData.append('uploadApproveName', this.e_signatureA);

      this.datarows.forEach(row => {
          const productData = {
              sproduct: row.sproduct,
              sdescription: row.sdescription,
              squantity: row.squantity,
              sunit: row.sunit,
              sunitprice: row.sunitprice,
              sdiscount: row.sdiscount,
              stotal: row.stotal,
          };
          console.log('Product Data:', productData);
          formData.append('products[]', JSON.stringify(productData));
      });


      console.log(formData);

      axios.post('http://localhost/Capstone-Project/backend/api/Inventory_Database/MPO_Queries/mpo_data.php/', formData)
        .then(response => {
          console.log(response.data);
          const Status = response.data.status;
          const Message = response.data.message;
          if (Status === "success") {
            this.$q.notify({
              message: `MPO ${this.MpoIDValue} save successfully!`,
              color: 'green',
              type: 'positive',
            });
            this.handleCancel();
          }
          if (Status === "fail") {
            this.$q.notify({
              color: 'negative',
              message: `${Message} Please try again.`,
            });
            this.handleCancel();
          }
        }).catch(error => {
          console.error('Error fetching data:', error.message);
        });
    },

    // Image Upload Properties
    triggerFileInput(type) {
      this.$refs[`${type}Input`].click();
    },
    handleFileChange(type, event) {
      const file = event.target.files[0];
      if (file) {
        // Convert file to URL if it's for logo
        if (type === 'logo') {
          this.previewLogo = URL.createObjectURL(file);
        }

        // Save the uploaded file reference based on type
        switch (type) {
          case 'logo':
            this.uploadPhoto = file;
            this.uploadedFileName = file.name;
            break;
          case 'prepared':
            this.e_signatureP = file;
            this.uploadPreparedName = file.name;
            break;
          case 'approve':
            this.e_signatureA = file;
            this.uploadApproveName = file.name;
            break;
        }

        console.log("Uploaded file:", file);
      }
    },



    defaultImageLogo(){
      return `/default_logo.png`;
    },
    defaultImage(){
      return `/default.png`;
    },
    // COMPUTATION DATA ! IF WORKING DO NOT GALAW GALAW THIS AREA
    updateTotalAmount() {
      // Calculate total amount from table
      const totalFromTable = this.datarows.reduce((acc, row) => {
        const quantity = parseFloat(row.squantity) || 0;
        const unitPrice = parseFloat(row.sunitprice) || 0;
        return acc + (quantity * unitPrice);
      }, 0);

      // Update total amount in table
      this.total_in_table = totalFromTable;

      // Parse and calculate additional costs and charges
      const deliveryCharge = this.deliver_charge ? parseFloat(this.deliver_charge) : 0;
      const otherCost = this.other_cost ? parseFloat(this.other_cost) : 0;
      const discountPercentage = this.discount ? parseFloat(this.discount) : 0;
      const vatPercentage = this.vat ? parseFloat(this.vat) : 0;
      const vatDecimal = vatPercentage / 100;

      // Calculate total amount including delivery charge and other costs
      let total;
      // Adjust total based on selectedOptions using if-else
      if (this.selectedOptions === 'add') {
        total = totalFromTable + deliveryCharge + otherCost;
      } else {
        total = totalFromTable + deliveryCharge - otherCost;
      }

      // Apply discount
      const discountDecimal = discountPercentage / 100;
      total -= totalFromTable * discountDecimal;

      // Calculate VAT
      const vatAmount = total * vatDecimal;

      // Calculate final total amount including VAT
      this.total_amount = total + vatAmount;
      console.log(this.total_amount);
    },

    addProduct() {
      let maxId = 0;
      this.datarows.forEach(row => {
        if (row.id > maxId) {
          maxId = row.id;
        }
      });
      const newId = maxId + 1;
      this.datarows.push({
        id: newId,
        sproduct: '',
        sdescription: '',
        squantity: '',
        sunit: '',
        sunitprice: '',
        stotal: '',
      });
    },
    deleteRow(id) {
      this.datarows = this.datarows.filter(row => row.id !== id);
    },
    computeTotal(row) {
      const quantity = parseFloat(row.squantity);
      const unitPrice = parseFloat(row.sunitprice);
      const discount = parseFloat(row.sdiscount);

      let total = quantity * unitPrice;
      if (!isNaN(discount) && discount >= 0) {
        const discountDecimal = discount / 100;
        const discountAmount = total * discountDecimal;
        total -= discountAmount;
      }

      row.stotal = isNaN(total) ? 0 : total;

      return row.stotal;
    },
    handleCancel(){
      this.personnel_Email = '';
      this.company_address = '';
      this.uploadPhoto = '';
      this.mpo_ref = '';
      this.date_purchased = '';
      this.selectedCategory = '';
      this.client_ref = '';
      this.wo_purchased = '';
      this.delivery_date_val = '';
      this.delivery_add_val = '';
      this.selectedSupplier = '';
      this.supplier_address = '';
      this.segregation = '';
      this.cleaning = '';
      this.drying = '';
      this.weighting = '';
      this.deliver_charge = '';
      this.discount = '';
      this.vat = '';
      this.other_cost = '';
      this.total_amount = '';
      this.total_in_table = '';
      this.notes_instructions = '';
      this.prepareSig = '';
      this.approvedby_name = '';
      this.e_signatureP = '';
      this.e_signatureA = '';
      this.datarows = [];
    },
    fetchCategoryData(){
      axios.get(`http://localhost/Capstone-Project/backend/api/Inventory_Database/MPO_Queries/mpo_data.php?get=category`)
      .then(response => {
          this.categories = response.data.categoryData.map(category => ({
            value: category.title,
            label: category.title
          }));
      })
      .catch(error => {
        // Handle any errors that occur during the HTTP request
        console.error('Error fetching data:', error.message);
      });
    },

    fetchSupplierData(){
      axios.get(`http://localhost/Capstone-Project/backend/api/Inventory_Database/MPO_Queries/mpo_data.php?get=supplier`)
      .then(response => {
          this.supplier_list = response.data.categoryData.map(supplier => ({
            value: supplier.supplier_name,
            label: supplier.supplier_name
          }));
      })
      .catch(error => {
        // Handle any errors that occur during the HTTP request
        console.error('Error fetching data:', error.message);
      });
    },
    fetchSupplierAddress(supplierName) {
      console.log(supplierName);
      const formData = {
        supplier: supplierName,
      };
      axios
        .post(
          `http://localhost/Capstone-Project/backend/api/Inventory_Database/MPO_Queries/supplier_address.php/`, formData
        )
        .then(response => {
          console.log(response.data.address);
          this.supplier_address = response.data.address;
        })
        .catch(error => {
          console.error("Error fetching supplier address:", error.message);
        });
    },
    refreshData(){
      this.fetchMPOdata();
    },
    fetchMPOdata(){
      axios.get(`http://localhost/Capstone-Project/backend/api/Inventory_Database/MPO_Queries/mpo_data.php?get=mpo`)
      .then(response => {
        let nextMPOID = response.data.nextMPOID;
        if (nextMPOID === undefined) {
            nextMPOID = 1;
        }
        // const currentDate = new Date();
        // const year = currentDate.getFullYear();
        // const month = ('0' + (currentDate.getMonth() + 1)).slice(-2);
        // const day = ('0' + currentDate.getDate()).slice(-2);
        const mpo_ref = `WEMA-MPO-${this.date_purchased}-${nextMPOID}`;
        this.MpoIDValue = nextMPOID;
        this.mpo_ref = mpo_ref;
      })
      .catch(error => {
        // Handle any errors that occur during the HTTP request
        console.error('Error fetching data:', error.message);
      });
    },

    onRegionChange() {
    //   console.log(this.selectedRegion.value);
    //   console.log(philippineData[this.selectedRegion.value]);
    //  // Access the province list for the selected region
      this.selectedProvince = null;
      this.selectedCity = null;
      this.selectedBarangay = null;
      const regionData = this.philippineData[this.selectedRegion.value].province_list;

      // Map the province names to options format
      this.provinceOptions = Object.keys(regionData).map(provinceName => ({
        label: provinceName,
        value: provinceName
      }));
      this.updateSuppAddress();
    },
    onProvinceChange() {
      // Check if selectedProvince is not null before accessing its value
      if (this.selectedProvince !== null) {
        this.selectedCity = null;
        this.selectedBarangay = null;
        const selectedProvinceData = this.philippineData[this.selectedRegion.value].province_list[this.selectedProvince.value];
        if (selectedProvinceData) {
          const municipalityData = selectedProvinceData.municipality_list;
          console.log(municipalityData);

          this.cityOptions = Object.keys(municipalityData).map(municipalityName => ({
            label: municipalityName,
            value: municipalityName
          }));
          this.updateSuppAddress();
        }
      }
    },
    onCityChange() {
      if (this.selectedCity !== null) {
        this.selectedBarangay = null;
        const selectedMunicipalityData = this.philippineData[this.selectedRegion.value].province_list[this.selectedProvince.value].municipality_list[this.selectedCity.value];
        if (selectedMunicipalityData) {
          const barangayList = selectedMunicipalityData.barangay_list;
          console.log(barangayList);

          this.barangayOptions = barangayList.map(barangayName => ({
            label: barangayName,
            value: barangayName
          }));
          this.updateSuppAddress();
        }
      }
    },
    onBaranggayChange() {
      if (this.selectedBarangay !== null) {
        this.updateSuppAddress();
      }
    },
    updateSuppAddress() {

      let address = '';
      if (this.selectedRegion) address += `${this.selectedRegion.label}, `;
      if (this.selectedProvince) address += `${this.selectedProvince.label}, `;
      if (this.selectedCity) address += `${this.selectedCity.label}, `;
      if (this.selectedBarangay) address += `${this.selectedBarangay.label}`;
      this.company_address = address;
    },

    onUserRegionSelect() {
  //   console.log(this.RegionDeliverySelected.value);
  //   console.log(philippineData[this.RegionDeliverySelected.value]);
  //  // Access the province list for the selected region
    this.ProvinceDeliverySelected = null;
    this.CityDeliverySelected = null;
    this.BaranggayDeliverySelected = null;
    const regionData = this.philippineData[this.RegionDeliverySelected.value].province_list;

    // Map the province names to options format
    this.provinceOptions = Object.keys(regionData).map(provinceName => ({
      label: provinceName,
      value: provinceName
    }));
    this.updateDeliverAddress();
    },
    onUserProvinceSelect() {
      // Check if ProvinceDeliverySelected is not null before accessing its value
      if (this.ProvinceDeliverySelected !== null) {
        this.CityDeliverySelected = null;
        this.BaranggayDeliverySelected = null;
        const ProvinceDeliverySelectedData = this.philippineData[this.RegionDeliverySelected.value].province_list[this.ProvinceDeliverySelected.value];
        if (ProvinceDeliverySelectedData) {
          const municipalityData = ProvinceDeliverySelectedData.municipality_list;
          console.log(municipalityData);

          this.cityOptions = Object.keys(municipalityData).map(municipalityName => ({
            label: municipalityName,
            value: municipalityName
          }));
          this.updateDeliverAddress();
        }
      }
    },
    onUserCitySelect() {
      if (this.CityDeliverySelected !== null) {
        this.BaranggayDeliverySelected = null;
        const selectedMunicipalityData = this.philippineData[this.RegionDeliverySelected.value].province_list[this.ProvinceDeliverySelected.value].municipality_list[this.CityDeliverySelected.value];
        if (selectedMunicipalityData) {
          const barangayList = selectedMunicipalityData.barangay_list;
          console.log(barangayList);

          this.barangayOptions = barangayList.map(barangayName => ({
            label: barangayName,
            value: barangayName
          }));
          this.updateDeliverAddress();
        }
      }
    },
    onUserBarangaySelect() {
      if (this.BaranggayDeliverySelected !== null) {
        this.updateDeliverAddress();
      }
    },
    updateDeliverAddress() {

      let address = '';
      if (this.RegionDeliverySelected) address += `${this.RegionDeliverySelected.label}, `;
      if (this.ProvinceDeliverySelected) address += `${this.ProvinceDeliverySelected.label}, `;
      if (this.CityDeliverySelected) address += `${this.CityDeliverySelected.label}, `;
      if (this.BaranggayDeliverySelected) address += `${this.BaranggayDeliverySelected.label}`;
      this.delivery_add_val = address;
    },

// OLD DATA
    toggleProduction(){
      this.productionVisible = !this.productionVisible;
    },
    toggleInventoryMenu() {
      this.inventoryMenuVisible = !this.inventoryMenuVisible;
    },
    toggleDrawer() {
      if (!this.toggleDrawers) {
        this.drawer = true;
        this.drawerWidth = 300;
        this.drawerIcon = 'arrow_forward_ios';
        this.toggleDrawers = true;
      } else {
        this.drawer = true;
        this.drawerWidth = 80;
        this.toggleDrawers = false;
        this.drawerIcon = 'arrow_back_ios_new';
      }
    },
    checkUserStatus() {
      axios.get(`http://localhost/Capstone-Project/backend/api/verification.php?email=${this.email}`)
      .then(response => {
        console.log(response.data);

        const information = response.data.information;
          this.information = {
            id: information.id,
            email: information.email,
            username: information.username,
            pfp: information.pfp,
            firstname: information.firstname,
            middlename: information.middlename,
            lastname: information.lastname,
            gender: information.gender,
            position: information.position,
            mobilenumber: information.mobilenumber,
            birthdate: information.birthdate,
            age: information.age,
            address: information.address,
            otp_code: information.otp_code,
            isOnline: information.isOnline,
            status: information.status,
            password: information.password,
            isAdmin: information.isAdmin,
          };
          SessionStorage.set('information', JSON.stringify(this.information));

          const latestAdmin = response.data.information.isAdmin;
          const latestStatus = response.data.information.status;

          if (this.status !== latestStatus || (latestAdmin && latestStatus === 0)) {
            this.status = latestStatus;

            if (this.status === 0 && !latestAdmin) {
              this.$q.notify({
                type: 'negative',
                message: 'Your account is currently inactive. Please contact the administrator.',
              });
              this.$router.push('/');
              sessionStorage.clear();
            }
          }
      }).catch(error => {
            console.error('Error fetching data:', error);
      });
    },
    loadUserData() {
      const userData = SessionStorage.getItem('information');

      if (userData) {
        try {
          const userInformation = JSON.parse(userData);
          this.email = userInformation.email;
          this.username = userInformation.username;
          this.userProfileImage = userInformation.pfp;
          this.firstname = userInformation.firstname;
          this.middlename = userInformation.middlename;
          this.lastname = userInformation.lastname;
          this.position = userInformation.position;
          this.status = userInformation.status;
          this.isAdmin = userInformation.isAdmin;
          this.fullname = this.firstname + " " + this.lastname;
          if (this.position.toLowerCase() === 'owner') {

            this.$router.push('/dashboard/mpoform-section');
          } else {

            this.$q.notify({
              type: 'negative',
              message: 'You do not have permission to access the system.',
            });
            this.$router.push('/');
            sessionStorage.clear();
          }

          if (this.status === 0 && !this.isAdmin) {
            this.$q.notify({
              type: 'negative',
              message: 'Your account is currently inactive. Please contact the administrator.',
            });
            this.$router.push('/');
            sessionStorage.clear();
          }

        } catch (error) {
          console.log('Error parsing user data:', error);
          // Provide user feedback or navigate to an error page
          this.$q.notify({
            type: 'negative',
            message: 'Error loading user data. Please try again.',
          });
          this.$router.push('/');
          sessionStorage.clear();
        }
      } else {
        // Handle the case when user data is not available
        this.$router.push('/');
        sessionStorage.clear();
      }
    },
    getLimitedFullname(fullname, maxLength) {
      if (fullname.length > maxLength) {
        return fullname.substring(0, maxLength) + '...';
      }
      return fullname;
    },
    getUserProfileImagePath() {
      // Ensure userProfileImage is not null before creating the path
      if (this.userProfileImage) {
        return `/pfp/${this.userProfileImage}`;
      } else {
        // Return a default path or handle it as per your requirement
        return '/default_profile.png';
      }
    },
    logout() {
      sessionStorage.clear();
      this.$router.push('/');
    },
  },
};
</script>
