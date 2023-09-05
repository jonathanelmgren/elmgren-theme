export const Notice_Variant = {
    TOP_FIXED: 'top-fixed',
    BOTTOM_FIXED: 'bottom-fixed',
    TOP_SCROLL: 'top-scroll',
    BOTTOM_SCROLL: 'bottom-scroll',
    INLINE: 'inline',
    TOAST: 'toast'
} as const

export const Notice_Status = {
    SUCCESS: 'success',
    INFO: 'info',
    WARNING: 'warning',
    ERROR: 'error'
} as const

export type NoticeVariantType = typeof Notice_Variant[keyof typeof Notice_Variant];
export type NoticeStatusType = typeof Notice_Status[keyof typeof Notice_Status];
