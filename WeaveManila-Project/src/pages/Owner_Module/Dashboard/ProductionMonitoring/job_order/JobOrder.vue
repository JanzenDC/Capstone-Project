<template>
  <div class=' px-4 py-3 rounded h-[500px] bg-white overflow-y-auto overflow-x-hidden'>
    <q-form @submit='sendingForm'>
      <div :class="{ 'hidden': !clickPage }">
        <div class='mt-10 flex justify-between'>
          <div>
            Page 1
          </div>
          <div>
            <q-btn label="next" icon-right="arrow_forward_ios" class="text-white bg-[#634832]" @click="clickPage = !clickPage"/>
          </div>
        </div>
        <q-separator class="mt-3"/>
        <div class="p-2 text-center w-full">
          <div class="font-bold text-h6">
            WEAVEMANILA INC.
          </div>
          <div>
            KM 543 DIVERSION ROAD STO.DOMINGO ALBAY
          </div>
          <div class="font-bold text-h5">
            JOB ORDER FORM - CARPET DIVISION
          </div>
        </div>
          <div class='w-[346px]'>
            <p>Endorsed<span class="text-red-600">*</span></p>
            <q-select outlined v-model="v_Endorsed" dense outline :options="optionsweaver" />
          </div>
          <div class='grid grid-cols-4 gap-2 mt-3'>
            <div>
              <p>J.O Ref. No.</p>
              <q-input v-model="v_JOrefNo" dense outlined disable class="mt-2 bg-grey-300"/>
            </div>
            <div>
              <p>Date</p>
              <q-input v-model="v_date" dense outlined class="mt-2" type="date"/>
            </div>
            <div>
              <p>Reference</p>
              <q-input v-model="v_Reference" dense outlined class="mt-2"/>
            </div>
            <div>
              <p>Delivery Date</p>
              <q-input v-model="v_deliverydate" dense outlined class="mt-2" type="date"

              lazy-rules
              :rules="[ val => val && val.length > 0 || 'Please input valid date']"/>
            </div>
          </div>

          <div class="mt-3">
            SERVICES
          </div>
          <div class='grid grid-cols-4 gap-2 mt-3'>
            <div>
              <label>Weaving</label>
              <q-input v-model="v_weaving" dense outlined class="mt-2" type='number'/>
            </div>
            <div>
              <label>Tassle</label>
              <q-input v-model="v_tassle" dense outlined class="mt-2" type='number'/>
            </div>
            <div>
              <label>Trimming</label>
              <q-input v-model="v_trimming" dense outlined class="mt-2" type='number'/>
            </div>
            <div>
              <label>Cleaning</label>
              <q-input v-model="v_cleaning" dense outlined class="mt-2" type='number'/>
            </div>

            <div>
              <label>Latexing</label>
              <q-input v-model="v_latexing" dense outlined class="mt-2" type='number'/>
            </div>
            <div>
              <label>Re-latexing</label>
              <q-input v-model="v_relatexing" dense outlined class="mt-2" type='number'/>
            </div>
            <div>
              <label>Piping</label>
              <q-input v-model="v_piping" dense outlined class="mt-2" type='number'/>
            </div>
            <div>
              <label>Cutting</label>
              <q-input v-model="v_cutting" dense outlined class="mt-2" type='number'/>
            </div>
          </div>

          <div class="mt-3">
            PRODUCT SPECIFICATION
          </div>
          <div class='grid grid-cols-4 gap-2 mt-3'>
            <div>
              <label>Description*</label>
              <q-input v-model="v_desc" dense outlined class="mt-2"
              lazy-rules
              :rules="[ val => val && val.length > 0 || 'Please input a value for description']"/>
            </div>
            <div>
              <label>Design/Pattern*</label>
              <q-input v-model="v_descpattern" dense outlined class="mt-2"

              lazy-rules
              :rules="[ val => val && val.length > 0 || 'Please input a value for design/pattern']"/>
            </div>
            <div>
              <label>Construction*</label>
              <q-input v-model="v_cons" dense outlined class="mt-2"

              lazy-rules
              :rules="[ val => val && val.length > 0 || 'Please input a value for construction']"/>
            </div>
            <div>
              <label>Size*</label>
              <div class='flex gap-2 mt-3'>
                <q-input v-model='v_width' type='number' dense outlined class='w-[80px]'
                    lazy-rules
                    :rules="[ val => val && val.length > 0 || '']"
                    :class="{ 'hidden': !v_optionselected }"
                  />

                  <q-input v-model='v_length' type='number' dense outlined class='w-[80px]'
                    lazy-rules
                    :rules="[ val => val && val.length > 0 || '']"
                    :class="{ 'hidden': !v_optionselected }"
                  />
                <q-select outlined v-model="v_optionselected" class='w-[110px]' dense outline :options="v_optionssize"
                lazy-rules
                :rules="[ val => val && val.length > 0 || '']"/>

              </div>
            </div>

            <div>
              <label>Date Started*</label>
              <q-input v-model="v_datestarted" dense outlined class="mt-2" type="date"

              lazy-rules
              :rules="[ val => val && val.length > 0 || 'Please input a value for date started']"/>
            </div>
            <div>
              <label>Date Finished</label>
              <q-input v-model="v_datefinished" dense outlined class="mt-2" type="date"/>
            </div>
            <div>
              <label>Leadtime (No. Days)</label>
              <q-input v-model="v_leadtime" dense outlined class="mt-2" disable />
            </div>
            <div>
              <label>Qouta (Inches)</label>
              <q-input v-model="v_qouta" dense outlined class="mt-2" type='number'/>
            </div>

            <div>
              <label>Quantity*</label>
              <q-input v-model="v_quantity" dense outlined class="mt-2" type='number'

              lazy-rules
              :rules="[ val => val && val.length > 0 || 'Please input a value for quantity.']"/>
            </div>
            <div>
              <label>Looms*</label>
              <q-input v-model="v_looms" dense outlined class="mt-2"
              type='number'
              lazy-rules
              :rules="[ val => val && val.length > 0 || 'Please input a value for looms']"/>
            </div>
            <div>
              <label>Color*</label>
              <q-input v-model="v_color" dense outlined class="mt-2"

              lazy-rules
              :rules="[ val => val && val.length > 0 || 'Please input a value for color']"/>
            </div>
          </div>

          <div class="mt-3">
            MATERIAL SPECIFICATION
          </div>
          <div class="mt-3">
            <q-table
              dense bordered
              :rows="mats_rows"
              :columns="mats_columns"
              row-key="index"
              virtual-scroll
              v-model:pagination="pagination"
              :rows-per-page-options="[0]"
              hide-bottom
              separator="cell"
            >
              <template v-slot:body="props">
                <q-tr :props="props">
                  <q-td key="type" :props="props">
                    {{ props.row.type }}
                  </q-td>

                  <q-td key="material_used" :props="props">
                    {{ props.row.material_used }}
                    <q-popup-edit v-model="props.row.material_used" title="Update Description" buttons v-slot="scope">
                      <q-input type="text" v-model="scope.value" dense autofocus />
                    </q-popup-edit>
                  </q-td>

                  <q-td key="consumption" :props="props">
                    {{ props.row.consumption }}
                    <q-popup-edit v-model="props.row.consumption" title="Update Description" buttons v-slot="scope">
                      <q-input type="number" v-model="scope.value" dense autofocus />
                    </q-popup-edit>
                  </q-td>
                  <q-td key="waste_allow" :props="props">
                    {{ props.row.waste_allow }}
                    <q-popup-edit v-model="props.row.waste_allow" title="Update Description" buttons v-slot="scope">
                      <q-input type="number" v-model="scope.value" dense autofocus />
                    </q-popup-edit>
                  </q-td>

                  <q-td key="total" :props="props">
                    {{ props.row.total }}
                    <q-popup-edit v-model="props.row.total" title="Update Description" buttons v-slot="scope">
                      <q-input type="number" v-model="scope.value" dense autofocus />
                    </q-popup-edit>
                  </q-td>

                  <q-td key="action" :props="props">
                    <div class="flex gap-2">
                      <q-btn v-if="props.row.action.plus" @click="handlePlus(props.row.type)" class='w-[32px] h-[32px] bg-[#F37E33] text-white' icon='add_box'>
                        <q-tooltip :offset="[0, 8]">Add row</q-tooltip>
                      </q-btn>


                      <q-btn v-if="props.row.action.delete" @click="handleDelete(props.row)" class='w-[32px] h-[32px] bg-[#B3261E] text-white' icon='delete'>
                        <q-tooltip :offset="[0, 8]">Remove</q-tooltip>
                      </q-btn>
                      <q-btn v-if="props.row.action.reset" @click="handleReset(props.row)" class='w-[32px] h-[32px] bg-[#916CCF] text-white' icon='restart_alt'>
                        <q-tooltip :offset="[0, 8]">Reset Value</q-tooltip>
                      </q-btn>

                    </div>
                  </q-td>

                </q-tr>
              </template>
            </q-table>
          </div>

          <div class=' mt-3'>
            Remarks
          </div>
          <div class="flex">
            <div class='w-1/2 mt-3 p-2'>
              <q-table
                dense bordered
                :rows="item_actual_rows"
                :columns="item_actual_columns"
                row-key="index"
                virtual-scroll
                v-model:pagination="pagination"
                :rows-per-page-options="[0]"
                hide-bottom
                separator="none"
              >
                <template v-slot:header-cell-quantity="props">
                  <q-th :props="props">
                    <div class='p-4 mb-5'>
                    </div>
                    {{ props.col.label }}
                  </q-th>
                </template>
                <template v-slot:header-cell-weight="props">
                  <q-th :props="props">
                    <div class='p-4 mb-1'>
                      Item Actual Weight
                    </div>
                    {{ props.col.label }}
                  </q-th>
                </template>
                <template v-slot:header-cell-unit="props">
                  <q-th :props="props">
                    <div class='p-4 mb-5'>
                    </div>
                    {{ props.col.label }}
                  </q-th>
                </template>
                <template v-slot:body="props">
                  <q-tr :props="props">
                    <q-td key="quantity" :props="props">
                      {{ props.row.quantity }}
                    </q-td>
                    <q-td key="weight" :props="props">
                      {{ props.row.weight }}
                      <q-popup-edit v-model="props.row.weight" title="Update Description" buttons v-slot="scope">
                        <q-input type="number" v-model="scope.value" dense autofocus />
                      </q-popup-edit>
                    </q-td>
                    <q-td key="unit" :props="props">
                      {{ props.row.unit }}
                    </q-td>
                  </q-tr>
                </template>
              </q-table>
            </div>
            <div class='w-1/2 mt-3 p-2'>
              <q-table
                dense bordered
                :rows="total_material_used_rows"
                :columns="total_material_used_cols"
                row-key="index"
                virtual-scroll
                v-model:pagination="pagination"
                :rows-per-page-options="[0]"
                hide-bottom
                separator="none"
              >
              </q-table>
            </div>

          </div>

          <div class="mt-3">
            DESIGN SPECIFICATION
          </div>
          <div class="mt-3">
            <q-table
              dense bordered
              :rows="design_rows"
              :columns="design_columns"
              row-key="index"
              virtual-scroll
              v-model:pagination="pagination"
              :rows-per-page-options="[0]"
              hide-bottom
              separator="cell"
            >
            <template v-slot:header-cell-action="props">
              <q-th :props="props">
                <q-btn class='w-[32px] h-[32px] bg-[#F37E33] text-white' icon='add_box' @click="handleAddRow">
                  <q-tooltip :offset="[0, 8]">Add Row</q-tooltip>
                </q-btn>
              </q-th>
            </template>
            <template v-slot:body="props">
              <q-tr :props="props">

                <q-td key="pattern_name" :props="props">
                  {{ props.row.pattern_name }}
                  <q-popup-edit v-model="props.row.pattern_name" title="Update Description" buttons v-slot="scope">
                    <q-input type="text" v-model="scope.value" dense autofocus />
                  </q-popup-edit>
                </q-td>

                <q-td key="DPI" :props="props">
                  {{ props.row.DPI }}
                  <q-popup-edit v-model="props.row.DPI" title="Update Description" buttons v-slot="scope">
                    <q-input type="text" v-model="scope.value" dense autofocus />
                  </q-popup-edit>
                </q-td>

                <q-td key="EPI" :props="props">
                  {{ props.row.EPI }}
                  <q-popup-edit v-model="props.row.EPI" title="Update Description" buttons v-slot="scope">
                    <q-input type="text" v-model="scope.value" dense autofocus />
                  </q-popup-edit>
                </q-td>

                <q-td key="threading" :props="props">
                  {{ props.row.threading }}
                  <q-popup-edit v-model="props.row.threading" title="Update Description" buttons v-slot="scope">
                    <q-input type="text" v-model="scope.value" dense autofocus />
                  </q-popup-edit>
                </q-td>

                <q-td key="harness_lift" :props="props">
                  {{ props.row.harness_lift }}
                  <q-popup-edit v-model="props.row.harness_lift" title="Update Description" buttons v-slot="scope">
                    <q-input type="text" v-model="scope.value" dense autofocus />
                  </q-popup-edit>
                </q-td>

                <q-td key="Pedal" :props="props">
                  {{ props.row.Pedal }}
                  <q-popup-edit v-model="props.row.Pedal" title="Update Description" buttons v-slot="scope">
                    <q-input type="text" v-model="scope.value" dense autofocus />
                  </q-popup-edit>
                </q-td>
                <q-td key="action" :props="props">
                <q-btn @click="handleDeleteRow(props.row)" class='w-[32px] h-[32px] bg-[#B3261E] text-white' icon='delete'>
                        <q-tooltip :offset="[0, 8]">Remove</q-tooltip>
                      </q-btn>
                </q-td>

              </q-tr>
            </template>
            </q-table>
          </div>

          <div class="mt-3">
            POST DATA SPECIFICATION
          </div>
          <div class="mt-3">
            <q-table
              dense bordered
              :rows="postdata_rows"
              :columns="postdata_columns"
              row-key="index"
              virtual-scroll
              v-model:pagination="pagination"
              :rows-per-page-options="[0]"
              hide-bottom
              separator="none"
            >
            <template v-slot:header-cell-action="props">
              <q-th :props="props">
                <q-btn class='w-[32px] h-[32px] bg-[#F37E33] text-white' icon='add_box' @click="handleAddRowPostData">
                  <q-tooltip :offset="[0, 8]">Add Row</q-tooltip>
                </q-btn>
              </q-th>
            </template>
            <template v-slot:header-cell-warp="props">
              <q-th :props="props">
                <div class='p-4 mb-5'></div>
                {{ props.col.label }}
              </q-th>
            </template>
            <template v-slot:header-cell-weft="props">
              <q-th :props="props">
                <div class='p-4 mb-1'>
                  Waste
                </div>
                {{ props.col.label }}
              </q-th>
            </template>
            <template v-slot:header-cell-insert="props">
              <q-th :props="props">
                <div class='p-4 mb-5'></div>
                {{ props.col.label }}
              </q-th>
            </template>

            <template v-slot:body="props">
              <q-tr :props="props">

                <q-td key="setting" :props="props">
                  {{ props.row.setting }}
                  <q-popup-edit v-model="props.row.setting" title="Update Description" buttons v-slot="scope">
                    <q-input type="number" v-model="scope.value" dense autofocus />
                  </q-popup-edit>
                </q-td>

                <q-td key="weaving" :props="props">
                  {{ props.row.weaving }}
                  <q-popup-edit v-model="props.row.weaving" title="Update Description" buttons v-slot="scope">
                    <q-input type="number" v-model="scope.value" dense autofocus />
                  </q-popup-edit>
                </q-td>

                <q-td key="output" :props="props">
                  {{ props.row.output }}
                  <q-popup-edit v-model="props.row.output" title="Update Description" buttons v-slot="scope">
                    <q-input type="number" v-model="scope.value" dense autofocus />
                  </q-popup-edit>
                </q-td>

                <q-td key="warp" :props="props">
                  {{ props.row.warp }}
                  <q-popup-edit v-model="props.row.warp" title="Update Description" buttons v-slot="scope">
                    <q-input type="number" v-model="scope.value" dense autofocus />
                  </q-popup-edit>
                </q-td>

                <q-td key="weft" :props="props">
                  {{ props.row.weft }}
                  <q-popup-edit v-model="props.row.weft" title="Update Description" buttons v-slot="scope">
                    <q-input type="number" v-model="scope.value" dense autofocus />
                  </q-popup-edit>
                </q-td>

                <q-td key="insert" :props="props">
                  {{ props.row.insert }}
                  <q-popup-edit v-model="props.row.insert" title="Update Description" buttons v-slot="scope">
                    <q-input type="number" v-model="scope.value" dense autofocus />
                  </q-popup-edit>
                </q-td>

                <q-td key="action" :props="props">
                  <q-btn @click="handleDeleteRowPostData(props.row)" class='w-[32px] h-[32px] bg-[#B3261E] text-white' icon='delete'>
                    <q-tooltip :offset="[0, 8]">Remove</q-tooltip>
                  </q-btn>
                </q-td>
              </q-tr>
            </template>
          </q-table>
          </div>

          <div class="mt-3">
            MATERIAL ISSUANCE
          </div>
          <div class="mt-3">
            <q-table
              dense bordered
              :rows="material_rows"
              :columns="material_cols"
              row-key="index"
              virtual-scroll
              v-model:pagination="pagination"
              :rows-per-page-options="[0]"
              hide-bottom
              separator="cell"
            >
            <template v-slot:header-cell-action="props">
              <q-th :props="props">
                <q-btn class='w-[32px] h-[32px] bg-[#F37E33] text-white' icon='add_box' @click="handleAddRowMaterial">
                  <q-tooltip :offset="[0, 8]">Add Row</q-tooltip>
                </q-btn>
              </q-th>
            </template>

            <template v-slot:body="props">
              <q-tr :props="props">
                <q-td key="date" :props="props">
                  {{ props.row.date }}
                  <q-popup-edit v-model="props.row.date" title="Update Description" buttons v-slot="scope">
                    <q-input type="date" v-model="scope.value" dense autofocus />
                  </q-popup-edit>
                </q-td>

                <q-td key="material_desc" :props="props">
                  {{ props.row.material_desc }}
                  <q-popup-edit v-model="props.row.material_desc" title="Update Description" buttons v-slot="scope">
                    <q-select outlined v-model="scope.value" :options="options" label="Outlined" />
                  </q-popup-edit>
                </q-td>

                <q-td key="quantity" :props="props">
                  {{ props.row.quantity }}
                  <q-popup-edit v-model="props.row.quantity" title="Update Description" buttons v-slot="scope">
                    <q-input type="number" v-model="scope.value" dense autofocus />
                  </q-popup-edit>
                </q-td>

                <q-td key="unit" :props="props">
                  kilogram
                  <q-popup-edit v-model="props.row.unit" title="Update Description" buttons v-slot="scope">
                    <q-input type="text" v-model="scope.value" dense autofocus />
                  </q-popup-edit>
                </q-td>

                <q-td key="returned" :props="props">
                  {{ props.row.returned }}
                  <q-popup-edit v-model="props.row.returned" title="Update Description" buttons v-slot="scope">
                    <q-input type="text" v-model="scope.value" dense autofocus />
                  </q-popup-edit>
                </q-td>

                <q-td key="balance" :props="props">
                  {{ props.row.balance }}
                </q-td>

                <q-td key="issued_by" :props="props">
                  {{ props.row.issued_by }}
                  <q-popup-edit v-model="props.row.issued_by" title="Update Description" buttons v-slot="scope">
                    <q-select outlined v-model="scope.value" :options="optionswarehouse" />
                  </q-popup-edit>
                </q-td>

                <q-td key="action" :props="props">
                  <q-btn @click="handleDeleteMaterial(props.row)" class='w-[32px] h-[32px] bg-[#B3261E] text-white' icon='delete'>
                    <q-tooltip :offset="[0, 8]">Remove</q-tooltip>
                  </q-btn>
                </q-td>
              </q-tr>
            </template>

          </q-table>
          </div>

          <div class="flex gap-2 mt-3">
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

      <div :class="{ 'hidden': clickPage }">
        <div class='mt-10 flex justify-between'>
          <div>
            Page 2
          </div>
          <div>
            <q-btn label="Previous" icon-right="arrow_forward_ios" class="text-white bg-[#634832]" @click="clickPage = !clickPage"/>
          </div>
        </div>
        <q-separator class="mt-3"/>
        <div class="mt-3">
          <!-- {{ v_globalstore }} / {{ storedata }} -->
          PRODUCTION MONITORING
        </div>
        <div class='mt-3'>
          <q-table
              dense bordered
              :rows="production_monitoring_rows"
              :columns="production_monitoring_columns"
              row-key="index"
              virtual-scroll
              v-model:pagination="pagination"
              :rows-per-page-options="[0]"
              hide-bottom
              separator="cell"
            >
            <template v-slot:header-cell-action="props">
              <q-th :props="props">
                <q-btn class='w-[32px] h-[32px] bg-[#F37E33] text-white' icon='add_box' @click="handleAddRowProductionMonitoring">
                  <q-tooltip :offset="[0, 8]">Add Row</q-tooltip>
                </q-btn>
              </q-th>
            </template>

            <template v-slot:body="props">
              <q-tr :props="props">

                <q-td key="date" :props="props">
                  {{ props.row.date }}
                  <q-popup-edit v-model="props.row.date" title="Update Description" buttons v-slot="scope">
                    <q-input type="date" v-model="scope.value" dense autofocus />
                  </q-popup-edit>
                </q-td>

                <q-td key="time_in" :props="props">
                  {{ formatTime(props.row.time_in) }}
                  <q-popup-edit v-model="props.row.time_in" title="Update Description" buttons v-slot="scope">
                    <q-input type="time" v-model="scope.value" dense autofocus />
                  </q-popup-edit>
                </q-td>

                <q-td key="time_out" :props="props">
                  {{ formatTime(props.row.time_out) }}
                  <q-popup-edit v-model="props.row.time_out" title="Update Description" buttons v-slot="scope">
                    <q-input type="time" v-model="scope.value" dense autofocus />
                  </q-popup-edit>
                </q-td>

                <q-td key="output_am" :props="props">
                  {{ props.row.output_am }}
                  <q-popup-edit v-model="props.row.output_am" title="Update Description" buttons v-slot="scope">
                    <q-input type="number" v-model="scope.value" dense autofocus />
                  </q-popup-edit>
                </q-td>

                <q-td key="ot_time_in" :props="props">
                  {{ formatTime(props.row.ot_time_in) }}
                  <q-popup-edit v-model="props.row.ot_time_in" title="Update Description" buttons v-slot="scope">
                    <q-input type="time" v-model="scope.value" dense autofocus />
                  </q-popup-edit>
                </q-td>

                <q-td key="ot_time_out" :props="props">
                  {{ formatTime(props.row.ot_time_out) }}
                  <q-popup-edit v-model="props.row.ot_time_out" title="Update Description" buttons v-slot="scope">
                    <q-input type="time" v-model="scope.value" dense autofocus />
                  </q-popup-edit>
                </q-td>

                <q-td key="ot_output" :props="props">
                  {{ props.row.ot_output }}
                  <q-popup-edit v-model="props.row.ot_output" title="Update Description" buttons v-slot="scope">
                    <q-input type="number" v-model="scope.value" dense autofocus />
                  </q-popup-edit>
                </q-td>

                <q-td key="total_output" :props="props">
                  {{ calculateTotalOutput(props.row) }}
                </q-td>

                <q-td key="action" :props="props">
                  <q-btn @click="handleDeleteProductionMonitoring(props.row)" class='w-[32px] h-[32px] bg-[#B3261E] text-white' icon='delete'>
                    <q-tooltip :offset="[0, 8]">Remove</q-tooltip>
                  </q-btn>
                </q-td>
              </q-tr>
            </template>
          </q-table>

          <div class='w-[300px] mt-6'>
            Checked by:
            <q-select outlined v-model="v_checkedby" dense outline :options="optionsProductionStaff" lazy-rules :rules="[ val => val && val.length > 0 || 'Please input something']"/>
          </div>

            <div class='mt-8 text-justify'>
              IMPORTANT:<br>
              ANG HOB ORDER NA ITO AY NAGSISILBING KONTRATA SA PAGITAN NG WEAVER AT KUMPANYA SA PROYEKTO O ORDER NA ANG BAWAT IMPORMASYON O DETALYE NG HOB ORDER AY PAG-AARI NG KUMPANIYA AT HINDI MAAARING ILABAS O IPAKITA KANINO MAN MALIBAN SA MGA NAMAMAHALA PRODUCTION. MAHALAGA NA ANG BAWAT DETALYE NG JOB ORDER AY MASUNOD SIMULA SA ALLOWABLE MATERIALS O MATERYALES NA DAPAT LAMANG MAGAMIT, QUALITY SPECIFICATION O KAILANGAN KALIDAD NG GAWA AT DESIGN DATA NA HINDI TUTUGMA SA ITINAKDANG SPECIFICATION SA J.O NA ITO AY MAY MATERYALES NA PWEDENG ITAPON O WASTE AT SA QUALITY NG GAWA
            </div>

            <div class='flex justify-end w-full items-end'>
              <div class="flex gap-2 mt-[100px]">
                <div>
                  <label>Upload E-signature</label>
                  <div class="flex items-center gap-2 mt-3 ">
                    <q-input v-model="s_uploadPreparedName" outlined dense label="BPrepared By" disable />
                    <q-btn @click="triggerFileInput('bprepared')" class="text-white bg-[#634832]">Change Photo</q-btn>
                    <input ref="bpreparedInput" type="file" style="display: none" @change="handleFileChange('bprepared', $event)">
                  </div>
                  <span>Weaver:</span>
                  <q-input v-model="s_prepared_name" dense outlined lazy-rules :rules="[ val => val && val.length > 0 || 'Please input something']"/>
                </div>
                <!-- <div>
                  <label>Upload E-signature</label>
                  <div class="flex items-center gap-2 mt-3">
                    <q-input v-model="s_uploadApproveName" outlined dense label="BApproved By" disable />
                    <q-btn @click="triggerFileInput('bapprove')" class="text-white bg-[#634832]">Change Photo</q-btn>
                    <input ref="bapproveInput" type="file" style="display: none" @change="handleFileChange('bapprove', $event)">
                  </div>
                  <span>Approved By:</span>
                  <q-input v-model="s_approvedby_name" dense outlined lazy-rules :rules="[ val => val && val.length > 0 || 'Please input something']"/>
                </div> -->
              </div>
            </div>
        </div>

        <div>
          <q-btn label="Submit" type="submit" color="primary"/>
        </div>
      </div>

    </q-form>
  </div>
</template>


<script>
import axios from 'axios';

export default {
  data() {
    return {
      pagination: [
        {
          rowsPerPage: 1000
        }
      ],
      v_Endorsed: '',
      v_JOrefNo: '',
      v_date: '',
      v_Reference: '',
      v_deliverydate: '',
      v_weaving: '',
      v_tassle: '',
      v_trimming: '',
      v_cleaning: '',
      v_latexing: '',
      v_relatexing: '',
      v_piping: '',
      v_cutting: '',
      v_desc: '',
      v_descpattern: '',
      v_cons: '',
      v_storeddata : '',
      v_length: '',
      v_width: '',
      v_optionssize: ['Feet', 'Meters', 'Centimeters', 'Millimeters','inches'],
      v_optionselected: '',

      v_datestarted: '',
      v_datefinished: '',
      v_leadtime: '',
      v_qouta: '',
      v_quantity: '',
      v_looms: '',
      v_color: '',
      v_checkedby: '',
      mats_columns: [
        { name: 'type', align: 'left', label: '', field: 'type', sortable: true },
        { name: 'material_used', align: 'left', label: 'Material Used', field: 'material_used', sortable: true },
        { name: 'consumption', align: 'left', label: 'Consumption in WT. (KG)', field: 'consumption', sortable: true },
        { name: 'waste_allow', align: 'right', label: 'Waste Allow', field: 'waste_allow', sortable: true },
        { name: 'total', align: 'right', label: 'Total Allow Issuance', field: 'total', sortable: true },
        { name: 'action', align: 'right', label: 'Action', field: 'action', sortable: true },
      ],
      mats_rows: [],

      design_columns: [
        { name: 'pattern_name', align: 'left', label: 'Pattern Name', field: 'pattern_name', sortable: true },
        { name: 'DPI', align: 'left', label: 'DPI', field: 'DPI', sortable: true },
        { name: 'EPI', align: 'left', label: 'EPI', field: 'EPI', sortable: true },
        { name: 'threading', align: 'left', label: 'Threading', field: 'threading', sortable: true },
        { name: 'harness_lift', align: 'left', label: 'Harness Lift', field: 'harness_lift', sortable: true },
        { name: 'Pedal', align: 'left', label: 'Pedal', field: 'Pedal', sortable: true },
        { name: 'action', align: 'center', label: '', field: 'action'},
      ],
      design_rows: [],

      postdata_columns: [
      { name: 'setting', align: 'left', label: 'Setting (W)', field: 'setting', sortable: true },
      { name: 'weaving', align: 'left', label: 'Weaving (W)', field: 'weaving', sortable: true },
      { name: 'output', align: 'left', label: 'Output Width', field: 'output', sortable: true },
      { name: 'warp', align: 'left', label: 'Warp', field: 'warp', sortable: true },
      { name: 'weft', align: 'left', label: 'Weft', field: 'weft', sortable: true },
      { name: 'insert', align: 'left', label: 'Insert', field: 'insert', sortable: true },
      { name: 'action', align: 'center', label: '', field: 'action'},
      ],
      postdata_rows: [],

      material_cols: [
      { name: 'date', align: 'left', label: 'Date', field: 'date', sortable: true },
      { name: 'material_desc', align: 'left', label: 'Material Description', field: 'material_desc', sortable: true },
      { name: 'quantity', align: 'left', label: 'Quantity', field: 'quantity', sortable: true },
      { name: 'unit', align: 'left', label: 'Unit', field: 'unit', sortable: true },
      { name: 'returned', align: 'left', label: 'Returned', field: 'returned', sortable: true },
      { name: 'balance', align: 'left', label: 'Balance', field: 'balance', sortable: true },
      { name: 'issued_by', align: 'left', label: 'Issued by', field: 'setting', sortable: true },
      { name: 'action', align: 'center', label: '', field: 'action'},
      ],
      material_rows: [],

      e_signatureP: '',
      uploadPreparedName: '',
      e_signatureA: '',
      uploadApproveName: '',
      approvedby_name: '',
      prepared_name: '',
      clickPage: true,
      s_esignatureP: '',
      s_uploadPreparedName: '',
      s_esignatureA: '',
      s_uploadApproveName: '',
      s_approvedby_name: '',
      s_prepared_name: '',

      production_monitoring_columns: [
        { name: 'date', align: 'left', label: 'Date', field: 'date', sortable: true },
        { name: 'time_in', align: 'left', label: 'Time in', field: 'time_in', sortable: true },
        { name: 'time_out', align: 'left', label: 'Time Out', field: 'time_out', sortable: true },
        { name: 'output_am', align: 'left', label: 'Output AM & PM', field: 'output_am', sortable: true },
        { name: 'ot_time_in', align: 'left', label: 'OT Time -  In', field: 'ot_time_in', sortable: true },
        { name: 'ot_time_out', align: 'left', label: 'OT Time -  Out', field: 'ot_time_out', sortable: true },
        { name: 'ot_output', align: 'left', label: 'OT Output', field: 'ot_output', sortable: true },
        { name: 'total_output', align: 'left', label: 'Total Output (Inches)', field: 'total_output', sortable: true },
        { name: 'action', align: 'center', label: '', field: 'action'},
      ],
      production_monitoring_rows: [],

      item_actual_columns: [
        { name: 'quantity', align: 'left', label: 'Quantity', field: 'quantity', sortable: true },
        { name: 'weight', align: 'left', label: 'Weight', field: 'weight', sortable: true },
        { name: 'unit', align: 'left', label: 'Unit', field: 'unit', sortable: true },
      ],
      item_actual_rows: [],
      total_material_used_cols: [
        { name: 'material_used', align: 'left', label: 'Material Used', field: 'material_used', sortable: true },
        { name: 'quantity', align: 'left', label: 'Quantity', field: 'quantity', sortable: true },
        { name: 'unit', align: 'left', label: 'Unit', field: 'unit', sortable: true },
      ],
      total_material_used_rows: [],
      options: [],
      optionswarehouse: [],
      optionsweaver: [],
      optionsProductionStaff: [],

      v_globalstore: 0,
      storedata: 0,
    };
  },
  watch: {
    mats_rows: {
      handler(newRows) {
        const materialDescQuantityMap = {};

        // Calculate the total quantity for each material_desc
        newRows.forEach(row => {
          const { material_used, quantity } = row;
          if (materialDescQuantityMap[material_used]) {
            materialDescQuantityMap[material_used] += quantity;
          } else {
            materialDescQuantityMap[material_used] = quantity;
          }
        });

        // Construct total_material_used_rows based on the calculated quantities
        const totalMaterialUsedRows = Object.entries(materialDescQuantityMap).map(([material_used, quantity]) => ({
          material_used,
          quantity,
          unit: '', // Add any default unit value here if necessary
        }));

        // Assign the calculated rows to total_material_used_rows
        this.total_material_used_rows = totalMaterialUsedRows;

        // Update options for q-select
        this.options = Object.keys(materialDescQuantityMap);
      },
      deep: true,
    },
    'material_rows': {
      handler(newRows) {
        const materialDescQuantityMap = {};

        // Calculate the total quantity for each material_desc
        newRows.forEach(row => {
          const { material_desc, quantity, returned } = row;
          if (materialDescQuantityMap[material_desc]) {
            materialDescQuantityMap[material_desc] += parseInt(quantity) - parseInt(returned); // Subtract returned quantity
          } else {
            materialDescQuantityMap[material_desc] = parseInt(quantity) - parseInt(returned); // Subtract returned quantity
          }
        });

        // Update the corresponding rows in total_material_used_rows
        this.total_material_used_rows.forEach(row => {
          const quantity = materialDescQuantityMap[row.material_used];
          if (quantity !== undefined) {
            row.quantity = quantity;
          } else {
            row.quantity = 0; // Reset quantity if not found in material_rows
          }
        });
      },
      deep: true,
    },
    convertedLengthInInches() {
      this.calculateLeadTime();
    },
    v_qouta() {
      this.calculateLeadTime();
    },
    v_datestarted() {
      this.calculateDateFinished();
    },
    v_leadtime() {
      this.calculateDateFinished();
    },
    v_quantity(newValue) {
      const quantity = parseInt(newValue);
      if (!isNaN(quantity) && quantity > 0) {
        this.addRows(quantity);
      }
    },
  },
  computed: {
    convertedLengthInInches() {
      if (!this.v_length || !this.v_optionselected) return null;

      const length = parseFloat(this.v_length);
      switch (this.v_optionselected) {
        case 'Feet':
          return length * 12; // 1 foot = 12 inches
        case 'Meters':
          return length * 39.3701; // 1 meter = 39.3701 inches
        case 'Centimeters':
          return length * 0.393701; // 1 centimeter = 0.393701 inches
        case 'Millimeters':
          return length * 0.0393701; // 1 millimeter = 0.0393701 inches
        case 'Inches':
        default:
          return length; // Already in inches
      }
    },
  },
  mounted() {
    const types = ['Warp', 'Weft', 'Insert'];

    // Add at least three rows to mats_rows array
    for (let i = 0; i < 3; i++) {
      let newRow = {
        type: types[i],
        consumption: 0,
        material_used: 'New Material ' + (i + 1),
        waste_allow: 0,
        total: 0,
        action: {
          plus: true,
          delete: false,
          reset: true,
        }
      };

      this.mats_rows.push(newRow);

    }
    this.handleAddRowPostData();
    this.handleAddRow();
    this.handleAddRowMaterial();
    this.handleAddRowProductionMonitoring();
    this.fetchWarehouseMan();
    this.fetchJOref();
    this.fetchWeaver();
    this.fetchProductionStaff();
  },
  methods: {
    calculateTotalOutput(row) {
      // Calculate total output
      if (!isNaN(row.output_am) && !isNaN(row.ot_output)) {
        const first = parseFloat(row.output_am) + parseFloat(row.ot_output);
        this.storedata = parseFloat(this.v_globalstore) - first;
        return parseFloat(row.output_am) + parseFloat(row.ot_output);
      } else {
        return 0;
      }
    },
    updateGlobalStore() {
      this.v_globalstore = this.convertedLengthInInches /  parseFloat(this.v_qouta);
    },
    calculateLeadTime() {
      this.updateGlobalStore()
      if (!this.v_qouta || !this.convertedLengthInInches) return;

      const quota = parseFloat(this.v_qouta);

      this.v_leadtime = Math.round(this.convertedLengthInInches / quota);
    },
    calculateDateFinished() {
      if (!this.v_datestarted || !this.v_leadtime) return;

      const startDate = new Date(this.v_datestarted);
      const leadTimeInMilliseconds = this.v_leadtime * 24 * 60 * 60 * 1000; // Convert lead time to milliseconds
      const dateFinished = new Date(startDate.getTime() + leadTimeInMilliseconds);

      // Format the date to 'YYYY-MM-DD' (required by q-input type="date")
      const formattedDate = dateFinished.toISOString().split('T')[0];

      this.v_datefinished = formattedDate; // Update v_datefinished
    },

    handlePlus(typeName) {
      // Find the index of the last occurrence of the same type
      let lastIndex = this.mats_rows.map(row => row.type).lastIndexOf(typeName);

      let newRow = {
        type: typeName,
        consumption: 0,
        material_used: 'New Material',
        waste_allow: 0,
        total: 0,
        action: {
          plus: false,
          delete: true
        }
      };

      // Insert the new row at the index of the last occurrence plus one
      this.mats_rows.splice(lastIndex + 1, 0, newRow);
    },
    handleDelete(row) {
      // Find the index of the row to be deleted
      let index = this.mats_rows.indexOf(row);
      // Remove the row from the array
      this.mats_rows.splice(index, 1);
    },
    handleReset(row) {
      row.consumption = 0;
      row.material_used = 'New Material';
      row.waste_allow = 0;
      row.total = 0;
    },

    handleDeleteRow(row) {
      // Find the index of the row to be deleted
      let index = this.design_rows.indexOf(row);
      // Remove the row from the array
      this.design_rows.splice(index, 1);
    },
    handleAddRow() {

      let newRow = {
        pattern_name: '',
        DPI: '',
        EPI: '',
        threading: '',
        harness_lift: '',
        Pedal: '',
        action: ''
      };
      this.design_rows.push(newRow);
    },

    handleDeleteRowPostData(row){
      // Find the index of the row to be deleted
      let index = this.postdata_rows.indexOf(row);
      // Remove the row from the array
      this.postdata_rows.splice(index, 1);
    },
    handleAddRowPostData() {
      const defaultRow = {
        setting: '',
        weaving: '',
        output: '',
        warp: '',
        weft: '',
        insert: '',
        action: ''
      };

      this.postdata_rows.push(defaultRow);
    },

    handleDeleteMaterial(row){
      // Find the index of the row to be deleted
      let index = this.material_rows.indexOf(row);
      // Remove the row from the array
      this.material_rows.splice(index, 1);
    },
    handleAddRowMaterial() {
      const defaultRow = {
        date: '',
        material_desc: '',
        quantity: 0,
        unit: 'kilogram',
        returned: 0,
        balance: '',
        issued_by: '',
        action: ''
      };
      this.material_rows.push(defaultRow);
    },
    triggerFileInputs(type) {
      this.$refs[`${type}Input`].click();
    },
    handleFileChanges(type, event) {
      const file = event.target.files[0];
      if (file) {

        // Save the uploaded file reference based on type
        switch (type) {
          case 'bprepared':
            this.s_esignatureP = file;
            this.s_s_uploadPreparedName = file.name;
            break;
          case 'bapprove':
            this.s_esignatureA = file;
            this.s_s_uploadApproveName = file.name;
            break;
        }

        console.log("Uploaded file:", file);
      }
    },
    triggerFileInput(type) {
      this.$refs[`${type}Input`].click();
    },
    handleFileChange(type, event) {
      const file = event.target.files[0];
      if (file) {
        // Save the uploaded file reference based on type
        switch (type) {
          case 'prepared':
            this.e_signatureP = file;
            this.uploadPreparedName = file.name;
            break;
          case 'approve':
            this.e_signatureA = file;
            this.uploadApproveName = file.name;
            break;
          case 'bprepared':
            this.s_esignatureP = file;
            this.s_uploadPreparedName = file.name;
            break;
          case 'bapprove':
            this.s_esignatureA = file;
            this.s_uploadApproveName = file.name;
            break;
        }
        console.log("Uploaded file:", file);
      }
    },

    sendingForm() {
      const formData = new FormData();

      formData.append('v_Endorsed', this.v_Endorsed);
      formData.append('v_JOrefNo', this.v_JOrefNo);
      formData.append('v_date', this.v_date);
      formData.append('v_Reference', this.v_Reference);
      formData.append('v_deliverydate', this.v_deliverydate);
      formData.append('v_weaving', this.v_weaving);
      formData.append('v_tassle', this.v_tassle);
      formData.append('v_trimming', this.v_trimming);
      formData.append('v_cleaning', this.v_cleaning);
      formData.append('v_latexing', this.v_latexing);
      formData.append('v_relatexing', this.v_relatexing);
      formData.append('v_piping', this.v_piping);
      formData.append('v_cutting', this.v_cutting);
      formData.append('v_desc', this.v_desc);
      formData.append('v_descpattern', this.v_descpattern);
      formData.append('v_cons', this.v_cons);

      formData.append('v_optionselected', this.v_optionselected);
      formData.append('v_length', this.v_length);
      formData.append('v_width', this.v_width);

      formData.append('v_datestarted', this.v_datestarted);
      formData.append('v_datefinished', this.v_datefinished);
      formData.append('v_leadtime', this.v_leadtime);
      formData.append('v_qouta', this.v_qouta);
      formData.append('v_quantity', this.v_quantity);
      formData.append('v_looms', this.v_looms);
      formData.append('v_color', this.v_color);
      formData.append('e_signatureP', this.e_signatureP);
      formData.append('e_signatureA', this.e_signatureA);
      formData.append('approvedby_name', this.approvedby_name);
      formData.append('prepared_name', this.prepared_name);
      formData.append('s_esignatureP', this.s_esignatureP);
      formData.append('s_esignatureA', this.s_esignatureA);
      formData.append('s_approvedby_name', this.s_approvedby_name);
      formData.append('s_prepared_name', this.s_prepared_name);
      formData.append('v_checkedby', this.v_checkedby);

      this.mats_rows.forEach(row => {
        const matsData = {
          type: row.type,
          consumption: row.consumption,
          material_used: row.material_used,
          waste_allow: row.waste_allow,
          total: row.total,
        };
        formData.append('material_specs[]', JSON.stringify(matsData));
      });

      // Append design data
      this.design_rows.forEach(row => {
        const designData = {
          pattern_name: row.pattern_name,
          DPI: row.DPI,
          EPI: row.EPI,
          threading: row.threading,
          harness_lift: row.harness_lift,
          Pedal: row.Pedal,
        };
        formData.append('designs[]', JSON.stringify(designData));
      });

      this.item_actual_rows.forEach(row => {
        const itemActualData = {
          quantity: row.quantity,
          weight: row.weight,
          unit: row.unit,
        };
        formData.append('item_actuals[]', JSON.stringify(itemActualData));
      });


      this.total_material_used_rows.forEach(row => {
        const materialUsedData = {
          material_used: row.material_used,
          quantity: row.quantity,
          unit: row.unit,
        };
        formData.append('total_material_used[]', JSON.stringify(materialUsedData));
      });


      // Append postdata data
      this.postdata_rows.forEach(row => {
        const postData = {
          setting: row.setting,
          weaving: row.weaving,
          output: row.output,
          warp: row.warp,
          weft: row.weft,
          insert: row.insert,
        };
        formData.append('postdata[]', JSON.stringify(postData));
      });

      // Append material data
      this.material_rows.forEach(row => {
        const materialData = {
          date: row.date,
          material_desc: row.material_desc,
          quantity: row.quantity,
          unit: row.unit,
          returned: row.returned,
          balance: row.balance,
          issued_by: row.issued_by,
        };
        formData.append('materials[]', JSON.stringify(materialData));
      });

      // Append production monitoring
      this.production_monitoring_rows.forEach(row => {
        const productionData = {
          date:  row.date,
          time_in: row.time_in,
          time_out: row.time_out,
          output_am: row.output_am,
          ot_time_in: row.ot_time_in,
          ot_time_out: row.ot_time_out,
          ot_output: row.ot_output,
          total_output: row.total_output,
        };
        formData.append('production_monitoring[]', JSON.stringify(productionData));
      });

      // query using axios post
      axios.post(`http://localhost/Capstone-Project/backend/api/ProductionMonitoring/job_order/job_order.php`, formData)
      .then((response) => {
          console.log(response.data);
      }).catch(error => {
        // Handle error if request fails
        console.error("Error sending file:", error);
      });
    },

    handleDeleteProductionMonitoring(row){
      // Find the index of the row to be deleted
      let index = this.production_monitoring_rows.indexOf(row);
      // Remove the row from the array
      this.production_monitoring_rows.splice(index, 1);
    },
    handleAddRowProductionMonitoring() {
      const newRow = {
        date: '',
        time_in: '',
        time_out: '',
        output_am: 0,
        ot_time_in: '',
        ot_time_out: '',
        ot_output: 0,
        total_output: '',
      };

      this.production_monitoring_rows.push(newRow);
    },
    formatTime(time) {
      // Check if the time is provided and is a valid format
      if (!time || !/^\d{2}:\d{2}$/.test(time)) {
        return ''; // return empty string or any default value if time is invalid
      }

      // Parse the time string to a Date object
      const [hours, minutes] = time.split(':');
      const parsedTime = new Date();
      parsedTime.setHours(parseInt(hours, 10));
      parsedTime.setMinutes(parseInt(minutes, 10));

      // Format the time as HH:MM AM/PM
      const formattedTime = parsedTime.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

      return formattedTime;
    },
    calculateTotal(outputAm, otOutput) {
      // Parse values as numbers (assuming they are string representations of numbers)
      const outputAmValue = parseFloat(outputAm);
      const otOutputValue = parseFloat(otOutput);

      // Check if values are valid numbers
      if (!isNaN(outputAmValue) && !isNaN(otOutputValue)) {
        // Calculate total_output
        return outputAmValue + otOutputValue;
      } else {
        return ''; // or any default value for invalid inputs
      }
    },

    addRows(quantity) {
      this.item_actual_rows = [];
      for (let i = 0; i < quantity; i++) {
        this.item_actual_rows.push({ quantity: i + 1, weight: '', unit: 'Kilogram' });
      }
    },

    // FETCH QUERY AREA
    fetchWarehouseMan() {
      axios.get('http://localhost/Capstone-Project/backend/api/ProductionMonitoring/job_order/job_order.php?type=get')
        .then((response) => {
          if (response.data.status === 'success') {
            const warehouseManData = response.data.WarehouseManData;
            const options = warehouseManData.map(item => (item.firstname + ' ' + item.lastname).trim());
            this.optionswarehouse = options.filter(label => label !== ''); // Filter out empty labels
          } else {
            console.error("Failed to fetch warehouseman data:", response.data.message);
          }
        }).catch(error => {
          console.error("Error fetching warehouseman data:", error);
        });
    },
    fetchJOref() {
      axios.get('http://localhost/Capstone-Project/backend/api/ProductionMonitoring/job_order/job_order.php?type=pjo')
        .then((response) => {
          if (response.data.status === 'success') {
            // Extract the next job order number from the response
            const nextJobOrderNo = response.data.nextJobOrderNo;
            // Format the job order number as "000" using string manipulation
            const formattedJobOrderNo = String(nextJobOrderNo).padStart(3, '0');

            // Assign the formatted job order number to v_JOrefNo
            this.v_JOrefNo = formattedJobOrderNo;

          } else {
            // Handle the case where fetching data fails
            console.error("Failed to fetch next job order number:", response.data.message);
          }
        }).catch(error => {
          // Handle error if request fails
          console.error("Error fetching next job order number:", error);
        });
    },
    fetchWeaver(){
      axios.get('http://localhost/Capstone-Project/backend/api/ProductionMonitoring/job_order/job_order.php?type=weaver')
      .then((response) => {
        if (response.data.status === 'success') {
          const weaverData = response.data.weaver;

          const options = weaverData.map(item => (item.weaverFname + ' ' + item.weaverLname).trim());
          this.optionsweaver = options.filter(label => label !== ''); // Filter out empty labels
        } else {
          console.error("Failed to fetch weaver data:", response.data.message);
        }
      }).catch(error => {
        console.error("Error fetching weaver data:", error);
      });
    },
    fetchProductionStaff(){
      axios.get('http://localhost/Capstone-Project/backend/api/ProductionMonitoring/job_order/job_order.php?type=production_staff')
      .then((response) => {
        if (response.data.status === 'success') {
          const productionData = response.data.production_staff;
          console.log(productionData)
          const options = productionData.map(item => (item.firstname + ' ' + item.lastname).trim());
          this.optionsProductionStaff = options.filter(label => label !== ''); // Filter out empty labels
        } else {
          console.error("Failed to fetch production staff data:", response.data.message);
        }
      }).catch(error => {
        console.error("Error fetching production staff data:", error);
      });
    }
  }
};
</script>
