interface JQuery {
    iris(options?: any, ...args: any[]): any;
}

declare namespace productVariations {
    const availableVariations: Record<string, any> | undefined
}

declare namespace elmAjax {
    const url: string
}

declare namespace wc_add_to_cart_params {
    const ajax_url: string;
    const ajax_url: string
    const wc_ajax_url: string
    const i18n_view_cart: string
    const cart_url: string
    const is_cart: string
    const cart_redirect_after_add: string
}

declare namespace wp {
    function customize(param: any): any
}
declare namespace acf {

    // Represents an ACF field object.
    interface Field {
        key: string;
        name: string;
        type: string;
        value: any;
        $el: JQuery;
        data: any;
        setData(name: string, value: any): void;
        getData(name: string): any;
        val(): any;
    }

    // Fetches a field object.
    function getField(key: string | JQuery): Field;

    // Fetches a field's value.
    function getFieldValue(key: string | JQuery): any;

    // Sets a field's value.
    function setFieldValue(key: string | JQuery, value: any, triggerChange?: boolean): void;

    // Adds a new row of values to a 'repeater' or 'flexible content' field.
    function addRow(name: string, value?: any, $before?: JQuery): any;

    // Removes a row of values from a 'repeater' or 'flexible content' field.
    function removeRow(name: string | JQuery): void;

    // Fetches a form element.
    function getForm($field: JQuery): JQuery;

    // Triggers an event on a field's element.
    function doAction(name: string, ...args: any[]): void;
    function addAction(name: string, callback: (...args: any[]) => void, priority?: number, context?: any): void;

    // Add, get, or set global data.
    function data(name: string, value?: any): any;

    function findFields(args?: Partial<Field>): any;

}