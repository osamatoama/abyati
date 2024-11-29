const helpers = {
    plugins: {
        datatables: {
            init: (columns, url, tableSelector = '#results-table', order = [[0, 'desc']], config = {}) => {
                const datatable = helpers.plugins.datatables.initDatatable(tableSelector, columns, url, order, config);
                return datatable
            },
            initDatatable: (tableSelector, columns, url, order = [[0, 'desc']], config = {}) => {
                let isArabic = document.querySelector('html').getAttribute('lang') == 'ar'
                const defaultConfig = {
                    language: {
                        url: isArabic ?
                            APP_BASE_URL + '/assets/client/plugins/custom/datatables/i18n/ar.json' :
                            APP_BASE_URL + '/assets/client/plugins/custom/datatables/i18n/en-GB.json',
                        processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>',
                        lengthMenu: "_MENU_",
                        search: isArabic ? "بحث: " : "Search: ",
                    },
                    scrollX: true,
                    processing: true,
                    serverSide: true,
                    dom: '<"d-flex justify-content-between"<"d-flex"<f><"ms-3"l>><B>>rt<"d-flex justify-content-between"ip>',
                    buttons: [],
                    order: order,
                    ajax: url,
                    columns: columns,
                }

                return $(tableSelector).DataTable({
                    ...defaultConfig,
                    ...config,
                });
            },
        },

        select2: {
            translations: {
                searching: {
                    en: "Searching...",
                    ar: "جاري البحث...",
                },
            },
        },
    },

    dictionary: {
        areYouSure: {
            en: "Are you sure ?",
            ar: "هل أنت متأكد من القيام بهذه العملية ؟",
        },
        noRevert: {
            en: "You won't be able to revert this !",
            ar: "لن يكون بإمكانك التراجع عن هذه العملية فى حالة التأكيد",
        },
        noRevertAccept: {
            en: "You won't be able to revert this !",
            ar: "لن يكون بإمكانك التراجع عن هذه العملية فى حالة تأكيد القبول",
        },
        noRevertDelete: {
            en: "You won't be able to revert this !",
            ar: "لن يكون بإمكانك التراجع عن هذه العملية فى حالة تأكيد الحذف",
        },
        noRevertDetach: {
            en: "You won't be able to revert this !",
            ar: "لن يكون بإمكانك التراجع عن هذه العملية فى حالة تأكيد الإزالة",
        },
        noRevertReject: {
            en: "You won't be able to revert this !",
            ar: "لن يكون بإمكانك التراجع عن هذه العملية فى حالة تأكيد الرفض",
        },
        noRevertCancel: {
            en: "You won't be able to revert this !",
            ar: "لن يكون بإمكانك التراجع عن هذه العملية فى حالة تأكيد الإلغاء",
        },
        deleteAlert: {
            en: "Data will be deleted. You can restore it later from trash",
            ar: "سيتم حذف البيانات. يمكنك القيام بالاستعادة مرة أخرى من سلة المهملات",
        },
        detachAlert: {
            en: "Data will be Detached",
            ar: "سيتم إزالة البيانات",
        },
        restoreAlert: {
            en: "Data will be restored again",
            ar: "سيتم استعادة البيانات مرة أخرى",
        },
        confirm: {
            en: "Confirm",
            ar: "تأكيد",
        },
        confirmDelete: {
            en: "Confirm Delete",
            ar: "تأكيد الحذف",
        },
        confirmDetach: {
            en: "Confirm Detach",
            ar: "تأكيد الإزالة",
        },
        confirmForceDelete: {
            en: "Delete Permanently",
            ar: "حذف نهائي",
        },
        confirmRestore: {
            en: "Confirm Restore",
            ar: "تأكيد الاستعادة",
        },
        confirmReject: {
            en: "Confirm Reject",
            ar: "تأكيد الرفض",
        },
        confirmCancel: {
            en: "Confirm Reject",
            ar: "تأكيد الإلغاء",
        },
        confirmAccept: {
            en: "Confirm Accept",
            ar: "تأكيد القبول",
        },
        confirmSubscription: {
            en: "Confirm subscription",
            ar: "تأكيد الاشتراك",
        },
        confirmRenewal: {
            en: "Confirm subscription renewal",
            ar: "تأكيد تجديد الاشتراك",
        },
        confirmIntegration: {
            en: "Confirm integration",
            ar: "تأكيد الربط",
        },
        cancel: {
            en: "Cancel",
            ar: "إلغاء",
        },
        discard: {
            en: "Discard",
            ar: "تراجع",
        },
        yes: {
            en: "Yes",
            ar: "نعم",
        },
        no: {
            en: "No",
            ar: "لا",
        },
        ok: {
            en: "Ok",
            ar: "حسناً",
        },
        all: {
            en: "All",
            ar: "الكل",
        },
        allStates: {
            en: "All States",
            ar: "جميع المناطق",
        },
        show: {
            en: "Show",
            ar: "عرض",
        },
        somethingWrong: {
            en: "Something went wrong !",
            ar: "حدث خطأ أثناء العملية !",
        },
        updatedSuccessfully: {
            en: "Updated successfully",
            ar: "تم التعديل بنجاح",
        },
        rejectedSuccessfully: {
            en: "Rejected successfully",
            ar: "تم الرفض بنجاح",
        },
        deletedSuccessfully: {
            en: "Delete successfully",
            ar: "تم الحذف بنجاح",
        },
        canceledSuccessfully: {
            en: "Canceled successfully",
            ar: "تم الإلغاء بنجاح",
        },
        integratedSuccessfully: {
            en: "Integrated successfully",
            ar: "تم الربط بنجاح",
        },
        warning: {
            en: "Warning",
            ar: "تنبيه",
        },
        warning: {
            en: "Warning",
            ar: "تنبيه",
        },
        defaultInternalStatusChange: {
            en: "The default internal status will be changed to ",
            ar: "سيتم تغيير الحالة الافتراضية إلى ",
        },
        sureToRestore: {
            en: "Are you sure you want to restore this record!",
            ar: "هل انت متأكد من استعادة هذا الصف!"
        },
        cancelShipmentAlert: {
            en: "Shipment will be canceled with its related label",
            ar: "سيتم إلغاء الشحنة والبوليصة التابعة لها",
        },
        cancelShipment: {
            en: "Cancel shipment",
            ar: "إلغاء الشحنة",
        },
        copiedToClipboard: {
            en: "Copied to clipboard",
            ar: "تم النسخ",
        },
        backToMenu: {
            en: "Back to menu",
            ar: "العودة للقائمة",
        },
    },
}
