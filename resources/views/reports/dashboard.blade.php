@extends('layout.layout')
@section('content')
<section class="bg-white mx-px md:mx-20 px-14 py-40">
   <div id= "loading-indicator" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
      <div class="inline-block h-8 w-8 animate-spin rounded-full border-4 border-solid border-current border-r-transparent align-[-0.125em] motion-reduce:animate-[spin_1.5s_linear_infinite]" role="status">
         <span class="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]">
         </span>
      </div> 
   </div>
   <!-- Index Total Reports -->
   <div class="col-span-12 rounded-sm border border-stroke bg-white p-8 shadow-default dark:border-strokedark dark:bg-boxdark">
      <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4 xl:gap-0">
         <div class="flex items-center justify-center gap-2 border-b border-stroke pb-5 dark:border-strokedark xl:border-b-0 xl:border-r xl:pb-0">
            <div>
               <h4 class="mb-0.5 text-xl font-bold text-black dark:text-white md:text-title-lg">
               {{ $totalReportCounts['totalReports'] }}
               </h4>
               <p class="text-sm font-medium">Total Reports</p>
            </div>
            <div class="flex items-center gap-1">
               <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M8.25259 5.87281L4.22834 9.89706L3.16751 8.83623L9.00282 3.00092L14.8381 8.83623L13.7773 9.89705L9.75306 5.87281L9.75306 15.0046L8.25259 15.0046L8.25259 5.87281Z" fill="#10B981"></path>
               </svg>
               <span class="text-sm font-medium text-meta-3">18%</span>
            </div>
         </div>
         <div class="flex items-center justify-center gap-2 border-b border-stroke pb-5 dark:border-strokedark xl:border-b-0 xl:border-r xl:pb-0">
            <div>
               <h4 class="mb-0.5 text-xl font-bold text-black dark:text-white md:text-title-lg">
               {{ $totalReportCounts['assignedReports'] }}
               </h4>
               <p class="text-sm font-medium">Total Assigned Reports</p>
            </div>
            <div class="flex items-center gap-1">
               <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M8.25259 5.87281L4.22834 9.89706L3.16751 8.83623L9.00282 3.00092L14.8381 8.83623L13.7773 9.89705L9.75306 5.87281L9.75306 15.0046L8.25259 15.0046L8.25259 5.87281Z" fill="#10B981"></path>
               </svg>
               <span class="text-sm font-medium text-meta-3">25%</span>
            </div>
         </div>
         <div class="flex items-center justify-center gap-2 border-b border-stroke pb-5 dark:border-strokedark sm:border-b-0 sm:pb-0 xl:border-r">
            <div>
               <h4 class="mb-0.5 text-xl font-bold text-black dark:text-white md:text-title-lg">
               {{ $totalReportCounts['urgentReports'] }}
               </h4>
               <p class="text-sm font-medium">Total Urgent Reports</p>
            </div>
            <div class="flex items-center gap-1">
               <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M9.75302 12.1328L13.7773 8.10856L14.8381 9.16939L9.00279 15.0047L3.16748 9.16939L4.22831 8.10856L8.25256 12.1328V3.00098H9.75302V12.1328Z" fill="#F0950C"></path>
               </svg>
               <span class="text-sm font-medium text-meta-8">7%</span>
            </div>
         </div>
         <div class="flex items-center justify-center gap-2">
            <div>
               <h4 class="mb-0.5 text-xl font-bold text-black dark:text-white md:text-title-lg">
               {{ $totalReportCounts['nonUrgentReports'] }}
               </h4>
               <p class="text-sm">Total Non-Urgent Reports</p>
            </div>
            <div class="flex items-center gap-1">
               <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M8.25259 5.87281L4.22834 9.89706L3.16751 8.83623L9.00282 3.00092L14.8381 8.83623L13.7773 9.89705L9.75306 5.87281L9.75306 15.0046L8.25259 15.0046L8.25259 5.87281Z" fill="#10B981"></path>
               </svg>
               <span class="text-meta-3">12%</span>
            </div>
         </div>
      </div>
   </div>
   <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-px mt-10">
        <!-- Radial Chart -->
        <div class="max-w-sm w-full bg-white rounded-lg shadow p-4 md:p-6">
            <div class="flex justify-between mb-3">
                <div class="flex items-center">
                    <div class="flex justify-center items-center">
                    <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white pr-1">Report Progress (Last 7 days)</h5>
                    <svg data-popover-target="chart-info" data-popover-placement="bottom" class="w-3.5 h-3.5 text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white cursor-pointer ml-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm0 16a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3Zm1-5.034V12a1 1 0 0 1-2 0v-1.418a1 1 0 0 1 1.038-.999 1.436 1.436 0 0 0 1.488-1.441 1.501 1.501 0 1 0-3-.116.986.986 0 0 1-1.037.961 1 1 0 0 1-.96-1.037A3.5 3.5 0 1 1 11 11.466Z"/>
                    </svg>
                    <div data-popover id="chart-info" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                        <div class="p-3 space-y-2">
                            <h3 class="font-semibold text-gray-900 dark:text-white">Activity growth - Incremental</h3>
                            <p>Report helps navigate cumulative growth of community activities. Ideally, the chart should have a growing trend, as stagnating chart signifies a significant decrease of community activity.</p>
                            <h3 class="font-semibold text-gray-900 dark:text-white">Calculation</h3>
                            <p>For each date bucket, the all-time volume of activities is calculated. This means that activities in period n contain all activities up to period n, plus the activities generated by your community in period.</p>
                            <a href="#" class="flex items-center font-medium text-blue-600 dark:text-blue-500 dark:hover:text-blue-600 hover:text-blue-700 hover:underline">
                                Read more 
                                <svg class="w-2 h-2 ml-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                </svg>
                            </a>
                        </div>
                        <div data-popper-arrow></div>
                    </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">
                <div class="grid grid-cols-3 gap-3 mb-2">
                    <dl class="bg-orange-50 dark:bg-gray-600 rounded-lg flex flex-col items-center justify-center h-[78px]">
                    <dt id="pending-count" class="w-8 h-8 rounded-full bg-orange-100 dark:bg-gray-500 text-orange-600 dark:text-orange-300 text-sm font-medium flex items-center justify-center mb-1">0</dt>
                    <dd class="text-orange-600 text-sm font-medium">Pending</dd>
                    </dl>
                    <dl class="bg-blue-50 dark:bg-gray-600 rounded-lg flex flex-col items-center justify-center h-[78px]">
                    <dt id="inprogress-count" class="w-8 h-8 rounded-full bg-blue-100 dark:bg-gray-500 text-blue-600 dark:text-teal-300 text-sm font-medium flex items-center justify-center mb-1">0</dt>
                    <dd class="text-blue-600 text-sm font-medium">Inprogress</dd>
                    </dl>
                    <dl class="bg-green-50 dark:bg-gray-600 rounded-lg flex flex-col items-center justify-center h-[78px]">
                    <dt id="finished-count" class="w-8 h-8 rounded-full bg-green-100 dark:bg-gray-500 text-lime-600 dark:text-blue-300 text-sm font-medium flex items-center justify-center mb-1">0</dt>
                    <dd class="text-green-600 text-sm font-medium">Finished</dd>
                    </dl>
                    <dl class="bg-red-50 dark:bg-gray-600 rounded-lg flex flex-col items-center justify-center h-[78px]">
                    <dt id="declined-count" class="w-8 h-8 rounded-full bg-red-100 dark:bg-gray-500 text-rose-600 dark:text-blue-300 text-sm font-medium flex items-center justify-center mb-1">0</dt>
                    <dd class="text-red-600 text-sm font-medium">Declined</dd>
                    </dl>
                </div>
                <button data-collapse-toggle="more-details" type="button" class="hover:underline text-xs text-gray-500 dark:text-gray-400 font-medium inline-flex items-center">
                    Show more details 
                    <svg class="w-2 h-2 ml-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                    </svg>
                </button>
                <div id="more-details" class="border-gray-200 border-t dark:border-gray-600 pt-3 mt-3 space-y-2 hidden">
                    <dl class="flex items-center justify-between">
                    <dt class="text-gray-500 dark:text-gray-400 text-sm font-normal">Average report completion rate:</dt>
                    <dd id="average-completion-rate" class="bg-green-100 text-green-800 text-xs font-medium inline-flex items-center px-2.5 py-1 rounded-md dark:bg-green-900 dark:text-green-300">
                        <svg class="w-2.5 h-2.5 mr-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13V1m0 0L1 5m4-4 4 4"/>
                        </svg>
                        57%
                    </dd>
                    </dl>
                    <dl class="flex items-center justify-between">
                    <dt class="text-gray-500 dark:text-gray-400 text-sm font-normal">Days until audit:</dt>
                    <dd class="bg-gray-100 text-gray-800 text-xs font-medium inline-flex items-center px-2.5 py-1 rounded-md dark:bg-gray-600 dark:text-gray-300">13 days</dd>
                    </dl>
                    <dl class="flex items-center justify-between">
                    <dt class="text-gray-500 dark:text-gray-400 text-sm font-normal">Next meeting:</dt>
                    <dd class="bg-gray-100 text-gray-800 text-xs font-medium inline-flex items-center px-2.5 py-1 rounded-md dark:bg-gray-600 dark:text-gray-300">Thursday</dd>
                    </dl>
                </div>
            </div>
            <!-- Radial Chart -->
            <div class="py-6" id="radial-chart"></div>
            <div class="grid grid-cols-1 items-center border-gray-200 border-t dark:border-gray-700 justify-between">
                <div class="flex justify-between items-center pt-5">
                    <!-- Button -->
                    <button
                    id="dropdownDefaultButton"
                    data-dropdown-toggle="lastDaysdropdown"
                    data-dropdown-placement="bottom"
                    class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-900 text-center inline-flex items-center dark:hover:text-white"
                    type="button">
                    Last 7 days
                    <svg class="w-2.5 m-2.5 ml-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                    </svg>
                    </button>
                    <div id="lastDaysdropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                        <li>
                            <a href="#" id="yesterday-button" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Yesterday</a>
                        </li>
                        <li>
                            <a href="#" id="today-button" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Today</a>
                        </li>
                        <li>
                            <a href="#" id="last-7-days-button" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Last 7 days</a>
                        </li>
                        <li>
                            <a href="#" id="last-30-days-button" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Last 30 days</a>
                        </li>
                        <li>
                            <a href="#" id="last-90-days-button" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Last 90 days</a>
                        </li>
                    </ul>
                    </div>
                    <a
                    href="#"
                    class="uppercase text-sm font-semibold inline-flex items-center rounded-lg text-blue-600 hover:text-blue-700 dark:hover:text-blue-500  hover:bg-gray-100 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700 px-3 py-2">
                    Progress report
                    <svg class="w-2.5 h-2.5 ml-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    </a>
                </div>
            </div>
        </div>
        <div class="grid grid-rows-2 gap-x-0.5 mt-10">
            <!-- Bar Chart -->
            <div class="mx-auto w-10/12 overflow-hidden">
                <canvas
                    data-te-chart="bar"
                    data-te-dataset-label="Reports Generated"
                    data-te-labels='@json(array_keys($barChartData["reportCounts"]))'
                    data-te-dataset-data='@json(array_values($barChartData["reportCounts"]))'
                    ></canvas>
            </div>
            <!-- Pie Chart -->
            <div class="mx-auto w-10/12 overflow-hidden">
                <canvas
                    data-te-chart="pie"
                    data-te-dataset-label="Severity"
                    data-te-labels="{{ json_encode(array_keys($pieChartData)) }}"
                    data-te-dataset-data="{{ json_encode(array_values($pieChartData)) }}"
                    data-te-dataset-background-color="['rgba(255, 235, 59, 0.5)', 'rgba(255, 152, 0, 0.5)', 'rgba(255, 0, 0, 0.5)']">
                </canvas>
            </div>
        </div>
    </div>
</section>
@endsection