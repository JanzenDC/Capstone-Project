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

      <li class="py-[10px] px-[20px] ">
        <div class="flex items-center gap-2">
          <i class="bi bi-box-seam"></i> <span >Product Monitoring</span>
        </div>
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
            <router-link @click="logout" to="/">
              <q-icon name="logout" class="h-[18px] w-[20px] font-bold"/>
            </router-link>
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
      <li class="mt-auto py-[10px]">
          <div class="flex justify-center ">
            <router-link @click="logout" to="/">
              <q-icon name="logout" class="h-[18px] w-[20px] font-bold"/>
            </router-link>
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

      <div class="w-full bg-white p-4 h-[480px] overflow-x-hidden overflow-y-auto">
        <div class='text-h6'>Material Purchase Order</div>
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

          <div class="flex items-center gap-3">
            <div>
              <label>Logo</label>
              <q-input
                @update:model-value="handleFileChangeLogo"
                dense outlined
                type="file"
                accept="image/png"
                class="w-[230px]"
                v-model="uploadPhoto"
              />
            </div>
            <div>
              <label>Company Address</label>
              <q-input v-model="company_address" dense outlined class="w-[723px]">
              </q-input>
            </div>
          </div>

          <div>
            <div class="flex items-center gap-4 mt-3">
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
                <q-input dense outlined v-model="client_ref" class="w-[230px]" lazy-rules :rules="[ val => val && val.length > 0 || 'Please input something']"/>
              </div>
              <div>
                <label>W.O Ref. No.</label>
                <q-input dense outlined v-model="wo_purchased" class="w-[230px]" lazy-rules :rules="[ val => val && val.length > 0 || 'Please input something']"/>
              </div>
            </div>

            <div class="flex items-center gap-4 ">
              <div>
                <label>Delivery Date</label>
                <q-input dense outlined v-model="delivery_date_val" type="date" class="w-[230px]" lazy-rules :rules="[ val => val && val.length > 0 || 'Please input something']"/>
              </div>
              <div>
                <label>Delivery Address</label>
                <q-input dense outlined v-model="delivery_add_val"  class="w-[720px]"         lazy-rules :rules="[ val => val && val.length > 0 || 'Please type something']"/>
              </div>
            </div>

            <div>
              <p class="text-h7 font-bold ">TO:</p>
              <div class="flex items-center gap-4">
                <div>
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
                <div>
                  <label>Supplier Address</label>
                  <q-input dense outlined v-model="supplier_address" class="w-[720px]" lazy-rules :rules="[ val => val && val.length > 0 || 'Please input something']"/>
                </div>
              </div>
            </div>

            <div>
              <p class="text-h7 font-bold ">Process:</p>
              <div class="flex items-center gap-4">
                <div>
                  <label>Segregation</label>
                  <q-input dense outlined v-model="segregation" class="w-[230px]" lazy-rules :rules="[ val => val && val.length > 0 || 'Please input something']"/>
                </div>
                <div>
                  <label>Cleaning</label>
                  <q-input dense outlined v-model="cleaning" class="w-[230px]" lazy-rules :rules="[ val => val && val.length > 0 || 'Please input something']"/>
                </div>
                <div>
                  <label>Drying</label>
                  <q-input dense outlined v-model="drying" class="w-[230px]" lazy-rules :rules="[ val => val && val.length > 0 || 'Please input something']"/>
                </div>
                <div>
                  <label>Weighting</label>
                  <q-input dense outlined v-model="weighting" class="w-[230px]" lazy-rules :rules="[ val => val && val.length > 0 || 'Please input something']"/>
                </div>
              </div>
            </div>

            <div>
              <div class="q-pa-md">
                <div class="mb-3 flex items-center justify-end">
                  <q-btn label="Add Product" icon="add" class="bg-[#634832] text-white" @click="addProduct" size="sm"/>
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
                      {{ props.row.sproduct }}
                      <q-popup-edit v-model="props.row.sproduct" title="Update Product" buttons v-slot="scope">
                        <q-input type="text" v-model="scope.value" dense autofocus />
                      </q-popup-edit>
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
                        <q-input type="text" v-model="scope.value" dense autofocus />
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
                <div class="flex justify-end items-center mt-2">
                  <div class="grid grid-cols-2 gap-1">

                      Delivery Charge
                      <q-input dense outlined v-model="deliver_charge" >
                        <template v-slot:append>
                          ₱
                        </template>
                      </q-input> <!--base on user input-->
                      Other Costs
                      <q-input dense outlined v-model="other_cost">
                        <template v-slot:append>
                          ₱
                        </template>
                      </q-input> <!--base on user input-->
                      Sub total
                      <q-input dense outlined v-model="total_in_table" disable>
                        <template v-slot:append>
                          ₱
                        </template>
                      </q-input>
                      Discount
                      <q-input dense outlined v-model="discount" disable>
                        <template v-slot:append>
                          ₱
                        </template>
                      </q-input> <!--substraction automatic 10%-->
                      Vat
                      <q-input dense outlined v-model="vat" disable>
                        <template v-slot:append>
                          ₱
                        </template>
                      </q-input><!--substraction automatic 12%-->

                      Total Amount
                      <q-input dense outlined v-model="total_amount" disable/>
                  </div>
                </div>
              </div>
            </div>

            <div>
              <div class="flex items-center gap-4">
                <div class="w-[532px]">
                  <label>Notes & Instruction<span class="text-red-600">*</span></label>
                  <q-input
                    v-model="notes_instructions"
                    outlined
                    :maxlength="120"
                    type="textarea"
                    class="w-full h-[132px] resize-none"
                  >
                  </q-input>
                  <span class="text-sm text-gray-400 flex justify-end">{{ characterCount }}/120</span>
                </div>
                <div class="flex gap-2">
                  <div>
                    <label>Upload E-signature</label>
                    <q-input
                      @update:model-value="handleFileChangePrepared"
                      dense outlined
                      type="file"
                      accept="image/png"
                      class="w-[200px]"
                      v-model="uploadPreparedSignature"
                    />
                    <label class="mt-3">Prepared By:</label>
                    <q-input v-model="prepared_name" dense outlined/>
                  </div>
                  <div>
                    <label>Upload E-signature</label>
                    <q-input
                      @update:model-value="handleFileChangeApproved"
                      dense outlined
                      type="file"
                      accept="image/png"
                      class="w-[200px]"
                      v-model="uploadApprovedSignature"
                    />
                    <label class="mt-3">Approved By:</label>
                    <q-input v-model="approvedby_name" dense outlined/>
                  </div>
                </div>
              </div>

            </div>
          </div>

          <div class="justify-end flex mt-3 gap-3 ">
            <q-btn label="Preview Form" @click="previewForm = true" class="bg-[#634832] rounded-md text-white"/>
            <q-btn label="Save" type="submit" class="bg-[#634832] rounded-md text-white"/>
          </div>
        </q-form>
      </div>

    </div>

    <q-dialog
    v-model="previewForm"
    full-width
    full-height
    >
      <q-card>
        <q-card-section>
          <div class="text-h6">MPO Form</div>
        </q-card-section>

        <q-card-section class="overflow-y-auto overflow-x-hidden h-[480px]">
          <div id="content" class="p-10">
            <div  class="flex">
              <div class="w-1/2">
                  <div class="p-10 text-center mt-[100px]">
                      <p class="text-5xl font-bold ">WEAVEMANILA INC.</p>
                      <p class="text-h6 mt-8">{{ company_address }}</p>
                  </div>
              </div>
              <div class="w-1/2  p-10 flex justify-center items-center">
                  <div class="w-[400px] ">
                      <div class="text-h5 font-bold text-center">MATERIAL PURCHASE ORDER</div>
                      <div class="mt-4">
                          <div class="grid grid-cols-2 ">
                              <div class="p-2">Date Purchase</div>
                              <div class="border-[#634832] border p-2 text-center">{{ date_purchased }}</div>
                          </div>
                          <div class="grid grid-cols-2 ">
                              <div class="p-2">MPO NO.</div>
                              <div class="border-[#634832] border p-2">{{ mpo_ref }}</div>
                          </div>
                          <div class="grid grid-cols-2 ">
                              <div class="p-2">CLIENT REFERENCE NO.</div>
                              <div class="border-[#634832] border p-2">{{ client_ref }}</div>
                          </div>
                          <div class="grid grid-cols-2 ">
                              <div class="p-2">W.O REFERENCE NO.</div>
                              <div class="border-[#634832] border p-2">{{ wo_purchased }}</div>
                          </div>
                          <div class="grid grid-cols-2 ">
                              <div class="p-2">DELIVERY DATE</div>
                              <div class="border-[#634832] border p-2">{{ delivery_date_val }}</div>
                          </div>
                          <div class="grid grid-cols-2 ">
                              <div class="p-2">DELIVERY ADDRESS</div>
                              <div class="border-[#634832] border p-2">{{ delivery_add_val }}</div>
                          </div>
                      </div>
                  </div>
              </div>
            </div>
            <div class="w-full p-2 flex justify-center items-center">
                <table class="w-full">
                    <thead class="bg-[#f6f8fa] text-left border">
                        <tr>
                            <th class="px-4 py-2 w-[500px]">To</th>
                            <th class="px-4 py-2">Process</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border">
                            <td class="px-4 py-2 border-l border">{{ selectedSupplier }}</td>
                            <td class="px-4 py-2 border-l border-r border grid grid-cols-2">
                              <p>
                                Segregation
                              </p>
                              <label>{{ segregation }}</label>
                            </td>
                        </tr>
                        <tr class="">
                            <td class="border-l "></td>
                            <td class="px-4 py-2 border-l border-r border grid grid-cols-2">
                              <p>
                                Cleaning
                              </p>
                              <label>{{ cleaning }}</label>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 border-l ">{{ supplier_address }}</td>
                            <td class="px-4 py-2 border-l border-r border-t border grid grid-cols-2">
                              <p>
                                Drying
                              </p>
                              <label>{{ drying }}</label>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 border-b border-l"></td>
                            <td class="px-4 py-2 border grid grid-cols-2">
                              <p>
                                Weighting
                              </p>
                              <label>{{ weighting }}</label>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="w-full p-2 flex justify-center items-center mt-6">
              <table class="w-full">
                <thead class="bg-[#f6f8fa] text-left">
                  <tr>
                    <th class="px-4 py-2 ">ID</th>
                    <th class="px-4 py-2">Product</th>
                    <th class="px-4 py-2">Description</th>
                    <th class="px-4 py-2">Quantity</th>
                    <th class="px-4 py-2">Unit</th>
                    <th class="px-4 py-2">Unit Price</th>
                    <th class="px-4 py-2">Discount</th>
                    <th class="px-4 py-2">Sub Total</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(row, index) in datarows" :key="index">
                    <td class="px-4 py-2">{{ index + 1 }}</td>
                    <td class="px-4 py-2">{{ row.sproduct }}</td>
                    <td class="px-4 py-2">{{ row.sdescription }}</td>
                    <td class="px-4 py-2">{{ row.squantity }}</td>
                    <td class="px-4 py-2">{{ row.sunit }}</td>
                    <td class="px-4 py-2">₱{{ row.sunitprice }}</td>
                    <td class="px-4 py-2">10</td>
                    <td class="px-4 py-2">₱{{ row.stotal }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="w-full p-2 flex items-center">
              <div class="w-1/2">
                <div class="border bg-[#f6f8fa] p-2">
                  Notes & Instructions
                </div>
                <div class="w-full h-[200px] border p-2">
                  {{ notes_instructions }}
                </div>
              </div>
              <div class="w-1/2 flex justify-end">
                <div class='grid grid-cols-2 w-[300px] text-h7'>
                  <div>Delivery Charge</div>
                  <div>₱ {{ deliver_charge }}</div>
                  <div>Other Costs</div>
                  <div>₱ {{ other_cost }}</div>
                  <div>Sub Total</div>
                  <div>₱ {{ total_in_table }}</div>
                  <div>Discount</div>
                  <div>₱ {{ discount }}</div>
                  <div>TAX/VAT</div>
                  <div>₱ {{ vat }}</div>
                  <div>Total Amount</div>
                  <div>₱ {{ total_amount }}</div>
                </div>
              </div>
            </div>
            <div class="w-full p-14 flex text-center justify-center items-center">
              <div class="w-1/2 text-center">
                <p class="font-bold">Approved by</p>
                <q-img
                  :src="previewApprovedSig || defaultImage()"
                  alt="Description of the image"
                  class="w-[50px] h-[50px]"
                />
                <p class="font-bold">{{ approvedby_name }}</p>
              </div>
              <div class="w-1/2 text-center">
                <p class="font-bold">Prepared by</p>
                <q-img
                  :src="previewPreparedSig || defaultImage()"
                  alt="Description of the image"
                  class="w-[50px] h-[50px]"
                />
                <p class="font-bold">{{ prepared_name }}</p>
              </div>
            </div>
          </div>
        </q-card-section>

        <q-card-actions align="right" class="bg-white text-teal">
          <q-btn @click="generatePDF">Generate PDF</q-btn>
          <q-btn flat label="OK" v-close-popup />
        </q-card-actions>
      </q-card>
    </q-dialog>
  </q-page>
  </template>

<script>
import jsPDF from 'jspdf';
import html2canvas from 'html2canvas';
import { SessionStorage } from 'quasar';
import axios from 'axios';

export default {
  data() {
    return {
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
      uploadPhoto: '',
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
        { name: 'sdiscount', align: 'left', label: 'Discount', field: 'sdiscount', sortable: true },
        { name: 'stotal', align: 'left', label: 'Sub Total', field: 'stotal', sortable: true },
        { name: 'sactions', align: 'left', label: 'Actions', field: 'sactions', sortable: true },
      ],
      datarows: [],
      initialPagination: {
        page: 1,
        rowsPerPage: 3
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
      uploadPreparedSignature: '',
      uploadApprovedSignature: '',
      approvedby_name: '',
      prepared_name: '',
      logo: null,
      esignature_p: null,
      esignature_a: null,

      previewForm: false,
      previewLogo: null,
      previewPreparedSig: null,
      previewApprovedSig: null,
    };
  },
  mounted() {
    this.loadUserData();
    this.fetchMPOdata();
    this.statusCheckTimer = setInterval(() => {
      this.checkUserStatus();
    }, 20 * 1000); // 1 second (in milliseconds)
    this.fetchCategoryData();
    this.fetchSupplierData();
  },
  watch: {
    logo: 'handleFileChangeLogo',
    esignature_p: 'handleFileChangePrepared',
    esignature_a: 'handleFileChangeApproved',
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
    sendingForm() {
      const formData = {
        company_address: this.company_address,
        uploadPhoto: this.uploadPhoto,
        mpo_ref: this.mpo_ref,
        date_purchased: this.date_purchased,
        selectedCategory: this.selectedCategory,
        client_ref: this.client_ref,
        wo_purchased: this.wo_purchased,
        delivery_date_val: this.delivery_date_val,
        delivery_add_val: this.delivery_add_val,
        selectedSupplier: this.selectedSupplier,
        supplier_address: this.supplier_address,
        segregation: this.segregation,
        cleaning: this.cleaning,
        drying: this.drying,
        weighting: this.weighting,
        deliver_charge: this.deliver_charge,
        discount: this.discount,
        vat: this.vat,
        other_cost: this.other_cost,
        total_amount: this.total_amount,
        total_in_table: this.total_in_table,
        notes_instructions: this.notes_instructions,
        uploadPreparedSignature: this.uploadPreparedSignature,
        uploadApprovedSignature: this.uploadApprovedSignature,
        pdfData: null
      };

      const pdf = new jsPDF();
      const content = document.getElementById('content');
      html2canvas(content).then(canvas => {
        const imgData = canvas.toDataURL('image/jpeg');
        const imgWidth = 210;
        const imgHeight = (canvas.height * 210) / canvas.width;
        pdf.addImage(imgData, 'JPEG', 0, 0, imgWidth, imgHeight);
        pdf.output('blob', function (blob) {
          formData.pdfData = blob;
          console.log(formData);
          // Example: this.$axios.post('/your-endpoint', formData)
        });
      });
    },
    generatePDF() {
      const pdf = new jsPDF();

      // Get the element containing your HTML content
      const content = document.getElementById('content');

      // Use html2canvas to render HTML to canvas
      html2canvas(content).then(canvas => {
        // Convert canvas to base64 image data
        const imgData = canvas.toDataURL('image/jpeg');

        // Set page dimensions
        const pageWidth = 210; // A4 width in mm
        const pageHeight = 297; // A4 height in mm

        // Calculate image dimensions while maintaining aspect ratio
        const imgWidth = pageWidth;
        const imgHeight = (canvas.height * pageWidth) / canvas.width;

        // Check if image exceeds page height
        let position = 0;
        if (imgHeight > pageHeight) {
          // Add new page
          pdf.addPage();
          position = -pageHeight; // Offset to account for starting from the top of the new page

          // Add image to the new page
          pdf.addImage(imgData, 'JPEG', 0, position, imgWidth, imgHeight);
        } else {
          // Add image to current page
          pdf.addImage(imgData, 'JPEG', 0, 0, imgWidth, imgHeight);
        }

        // Add remaining part of the image to subsequent pages if needed
        while (position + pageHeight < imgHeight) {
          position += pageHeight;
          pdf.addPage();
          pdf.addImage(imgData, 'JPEG', 0, -position, imgWidth, imgHeight);
        }

        // Save PDF
        pdf.save('document.pdf');
      });
    },
    // Image Upload Properties
    handleFileChangeLogo(event) {
      this.uploadPhoto = event[0];
      if (event && event[0]) {
        const file = event[0];
        this.file = event;
        this.previewLogo = URL.createObjectURL(file);
      }
    },
    handleFileChangePrepared(event) {
      this.uploadPreparedSignature = event[0];
      if (event && event[0]) {
        const file = event[0];
        this.file = event;
        this.previewPreparedSig = URL.createObjectURL(file);
      }
    },
    handleFileChangeApproved(event) {
      this.uploadApprovedSignature = event[0];
      if (event && event[0]) {
        const file = event[0];
        this.file = event;
        this.previewApprovedSig = URL.createObjectURL(file);
      }
    },
    defaultImage(){
      return `/default.jpg`;
    },
    // COMPUTATION DATA ! IF WORKING DO NOT GALAW GALAW THIS AREA
    updateTotalAmount() {
      // Compute the total from the table
      // SUBTOTAL
      const totalFromTable = this.datarows.reduce((acc, row) => {
        const quantity = parseFloat(row.squantity) || 0;
        const unitPrice = parseFloat(row.sunitprice) || 0;
        return acc + (quantity * unitPrice);
      }, 0);
      this.total_in_table = totalFromTable;
      // ALL Discount
      const discountFromTable = this.datarows.reduce((acc, row) => {
        const discount = parseFloat(row.sdiscount) || 0;
        const discountDecimal = discount / 100;
        const total = parseFloat(row.stotal) || 0;
        return acc + (discountDecimal * total);
      }, 0);
      this.discount = discountFromTable;

      const vatFromTable = this.datarows.reduce((acc, row) => {
        const VatValue = 12;
        const vat = parseFloat(VatValue) || 0;
        const vatDecimal = vat / 100;
        const total = parseFloat(row.stotal) || 0;
        return acc + (vatDecimal * total);
      }, 0);
      this.vat = vatFromTable;
      // // Compute the total amount
      // const discountPercentage = parseFloat(this.discount) / 100;
      // const vatPercentage = parseFloat(this.vat) / 100;

      // const discountAmount = discountPercentage * totalFromTable;
      // const vatAmount = vatPercentage * totalFromTable;
      const deliveryCharge = parseFloat(this.deliver_charge) || 0;
      const otherCost = parseFloat(this.other_cost) || 0;



        this.total_amount = totalFromTable - discountFromTable + vatFromTable + deliveryCharge - otherCost;
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
      console.log(id);
    },
    computeTotal(row) {
      const quantity = parseFloat(row.squantity);
      const unitPrice = parseFloat(row.sunitprice);
      const discount = parseFloat(row.sdiscount); // Assuming sdiscount is the discount percentage

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
      this.mpo_ref= '';
      this.date_purchased= '';
      this.selectedCategory= '';
      this.client_ref= '';
      this.wo_purchased= '';
      this.delivery_date_val= '';
      this.delivery_add_val= '';

      this.selectedSupplier='';
      this.supplier_address= '';

      this. segregation= '';
      this.cleaning= '';
      this.drying= '';
      this.weighting= '';
    },
    fetchCategoryData(){
      axios.get(`http://localhost/Capstone-Project/backend/api/Inventory_Database/MPO_Queries/mpo_data.php?get=category`)
      .then(response => {
          this.categories = response.data.categoryData.map(category => ({
            value: category.categoryID,
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
    refreshData(){
      this.fetchMPOdata();
    },
    fetchMPOdata(){
      axios.get(`http://localhost/Capstone-Project/backend/api/Inventory_Database/MPO_Queries/mpo_data.php?get=mpo`)
      .then(response => {
        const nextMPOID = response.data.nextMPOID;
        const currentDate = new Date();
        const year = currentDate.getFullYear();
        const month = ('0' + (currentDate.getMonth() + 1)).slice(-2);
        const day = ('0' + currentDate.getDate()).slice(-2);
        const mpo_ref = `WEMA-MPO-${year}-${month}-${day}-${nextMPOID}`;
        console.log(mpo_ref);


        this.mpo_ref = mpo_ref;
      })
      .catch(error => {
        // Handle any errors that occur during the HTTP request
        console.error('Error fetching data:', error.message);
      });
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
        const latestStatus = response.data.information.status;
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
          };
          SessionStorage.set('information', JSON.stringify(this.information));
        // Update the local status and take appropriate action if it has changed
        if (this.status !== latestStatus) {
          this.status = latestStatus;

          if (this.status === 0) {
            this.$q.notify({
              type: 'negative',
              message: 'Your account is currently inactive. Please contact the account owner for activation.',
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

          if (this.status == 0) {

            this.$q.notify({
              type: 'negative',
              message: 'Your account is currently inactive. Please contact the account owner for activation.',
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

