<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'The :attribute يجب الموافقة عليه',
    'active_url'           => 'The :attribute الرابط غير صالح',
    'after'                => 'The :attribute يجب ان يكون هناك تاريخ بعد :date.',
    'after_or_equal'       => 'The :attribute يجب ان يكون هناك تاريخ بعد أو على :date.',
    'alpha'                => 'The :attribute يجب ان يحتوى على حروف فقط',
    'alpha_dash'           => 'The :attribute يجب ان يحتوى على حروف وارقام وعلامات',
    'alpha_num'            => 'The :attribute يجب ان يحتوى على حروف وارقام فقط',
    'array'                => 'The :attribute يجب ان تكون مصفوفة',
    'before'               => 'The :attribute يجب ان يكون هناك تاريخ قبل :date.',
    'before_or_equal'      => 'The :attribute يجب ان يكون هناك تاريخ قبل او على :date.',
    'between'              => [
        'numeric' => 'The :attribute يجب ان يكون بين :min و :max.',
        'file'    => 'The :attribute يجب ان يكون بين :min و :max كيلو بايت.',
        'string'  => 'The :attribute يجب ان يكون بين :min و :max حرف.',
        'array'   => 'The :attribute يجب ان يكون بين :min و :max عنصر.',
    ],
    'boolean'              => 'The :attribute يجب ان يكون صحيح او خاطئ',
    'confirmed'            => 'The :attribute التأكيد لا يطابق',
    'date'                 => 'The :attribute التاريخ غير صالح',
    'date_format'          => 'The :attribute لا يتوافق مع الصيغة :format.',
    'different'            => 'The :attribute و :other يجب ان يكونو مختلفين',
    'digits'               => 'The :attribute يجب ان يكون :digits ارقام.',
    'digits_between'       => 'The :attribute يجب ان يكون بين :min و :max رقم.',
    'dimensions'           => 'The :attribute ابعاد الصورة غير صالحة',
    'distinct'             => 'The :attribute الحقل به قيمة مكررة',
    'email'                => 'The :attribute يجب  ان يكون البريد الإلكترونى صالح',
    'exists'               => 'المشار إليه :attribute غير صالح',
    'file'                 => 'The :attribute يجب ان يكون ملف',
    'filled'               => 'The :attribute الحقل يجب ان يكون به قيمة',
    'gt'                   => [
        'numeric' => 'The :attribute يجب ان يكون اكبر من :value.',
        'file'    => 'The :attribute يجب ان يكون اكبر من :value كيلو بايت.',
        'string'  => 'The :attribute يجب ان يكون اكبر من :value حرف.',
        'array'   => 'The :attribute يجب ان يكون به اكثر من :value بند.',
    ],
    'gte'                  => [
        'numeric' => 'The :attribute يجب ان يكون اكبر من او يساوى :value.',
        'file'    => 'The :attribute يجب ان يكون اكبر من او يساوى :value كيلو بايت.',
        'string'  => 'The :attribute يجب ان يكون اكبر من او يساوى :value حرف.',
        'array'   => 'The :attribute يجب ان يحتوى على :value بند او اكثر',
    ],
    'image'                => 'The :attribute يجب ان تكون صورة',
    'in'                   => 'المشار إليه :attribute غير صالح',
    'in_array'             => 'The :attribute الحقل غير موجود فى :other.',
    'integer'              => 'The :attribute يجب ان يكون عدد صحيح',
    'ip'                   => 'The :attribute يجب ان يكون عنوان الكترونى',
    'ipv4'                 => 'The :attribute must be a valid IPv4 address.',
    'ipv6'                 => 'The :attribute must be a valid IPv6 address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'lt'                   => [
        'numeric' => 'The :attribute must be less than :value.',
        'file'    => 'The :attribute must be less than :value kilobytes.',
        'string'  => 'The :attribute must be less than :value characters.',
        'array'   => 'The :attribute must have less than :value items.',
    ],
    'lte'                  => [
        'numeric' => 'The :attribute must be less than or equal :value.',
        'file'    => 'The :attribute must be less than or equal :value kilobytes.',
        'string'  => 'The :attribute must be less than or equal :value characters.',
        'array'   => 'The :attribute must not have more than :value items.',
    ],
    'max'                  => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'file'    => 'The :attribute may not be greater than :max kilobytes.',
        'string'  => 'The :attribute may not be greater than :max characters.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => 'The :attribute must be a file of type: :values.',
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => 'The :attribute must be at least :min.',
        'file'    => 'The :attribute must be at least :min kilobytes.',
        'string'  => 'The :attribute must be at least :min characters.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'The selected :attribute is invalid.',
    'not_regex'            => 'The :attribute format is invalid.',
    'numeric'              => 'The :attribute must be a number.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => 'The :attribute format is invalid.',
    'required'             => 'The :attribute field is required.',
    'required_if'          => 'The :attribute field is required when :other is :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'The :attribute field is required when :values is present.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => 'The :attribute and :other must match.',
    'size'                 => [
        'numeric' => 'The :attribute must be :size.',
        'file'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute must be :size characters.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => 'The :attribute has already been taken.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => 'The :attribute format is invalid.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
