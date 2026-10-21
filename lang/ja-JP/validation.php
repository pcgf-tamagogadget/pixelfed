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

    'accepted' => ':attribute を承認してください。',
    'accepted_if' => ':other が :value の場合、:attribute を承認してください。',
    'active_url' => ':attribute は有効なURLではありません。',
    'after' => ':attribute は :date より後の日付である必要があります。',
    'after_or_equal' => ':attribute は :date 以降の日付である必要があります。',
    'alpha' => ':attribute には英字のみ使用できます。',
    'alpha_dash' => ':attribute には英数字、ダッシュ（-）、アンダースコア（_）のみ使用できます。',
    'alpha_num' => ':attribute には英数字のみ使用できます。',
    'any_of' => ':attribute が無効です。',
    'array' => ':attribute は配列である必要があります。',
    'ascii' => ':attribute には半角英数字と記号のみ使用できます。',
    'before' => ':attribute は :date より前の日付である必要があります。',
    'before_or_equal' => ':attribute は :date 以前の日付である必要があります。',
    'between' => [
        'array' => ':attribute は :min 個から :max 個の項目である必要があります。',
        'file' => ':attribute は :min キロバイトから :max キロバイトの間である必要があります。',
        'numeric' => ':attribute は :min から :max の間である必要があります。',
        'string' => ':attribute は :min 文字から :max 文字の間である必要があります。',
    ],
    'boolean' => ':attribute は true か false である必要があります。',
    'can' => ':attribute に許可されていない値が含まれています。',
    'confirmed' => ':attribute の確認が一致しません。',
    'contains' => ':attribute に必要な値が含まれていません。',
    'current_password' => 'パスワードが正しくありません。',
    'date' => ':attribute は有効な日付ではありません。',
    'date_equals' => ':attribute は :date と同じ日付である必要があります。',
    'date_format' => ':attribute は :format の形式と一致しません。',
    'decimal' => ':attribute は小数点以下 :decimal 桁である必要があります。',
    'declined' => ':attribute を拒否してください。',
    'declined_if' => ':other が :value の場合、:attribute を拒否してください。',
    'different' => ':attribute と :other は異なる値である必要があります。',
    'digits' => ':attribute は :digits 桁の数字である必要があります。',
    'digits_between' => ':attribute は :min 桁から :max 桁の数字である必要があります。',
    'dimensions' => ':attribute の画像サイズが無効です。',
    'distinct' => ':attribute に重複した値があります。',
    'doesnt_contain' => ':attribute には次のいずれも含めることはできません: :values',
    'doesnt_end_with' => ':attribute は次のいずれかで終わってはいけません: :values',
    'doesnt_start_with' => ':attribute は次のいずれかで始まってはいけません: :values',
    'email' => ':attribute は有効なメールアドレスである必要があります。',
    'encoding' => ':attribute は :encoding でエンコードされている必要があります。',
    'ends_with' => ':attribute は次のいずれかで終わる必要があります: :values',
    'enum' => '選択された :attribute は無効です。',
    'exists' => '選択された :attribute は無効です。',
    'extensions' => ':attribute は次のいずれかの拡張子である必要があります: :values',
    'file' => ':attribute はファイルである必要があります。',
    'filled' => ':attribute には値を入力してください。',
    'gt' => [
        'array' => ':attribute は :value 個より多くの項目が必要です。',
        'file' => ':attribute は :value キロバイトより大きい必要があります。',
        'numeric' => ':attribute は :value より大きい必要があります。',
        'string' => ':attribute は :value 文字より多い必要があります。',
    ],
    'gte' => [
        'array' => ':attribute は :value 個以上の項目が必要です。',
        'file' => ':attribute は :value キロバイト以上である必要があります。',
        'numeric' => ':attribute は :value 以上である必要があります。',
        'string' => ':attribute は :value 文字以上である必要があります。',
    ],
    'hex_color' => ':attribute は有効な16進数のカラーコードである必要があります。',
    'image' => ':attribute は画像である必要があります。',
    'in' => '選択された :attribute は無効です。',
    'in_array' => ':attribute は :other に存在しません。',
    'in_array_keys' => ':attribute には次のキーのうち少なくとも1つが含まれている必要があります: :values',
    'integer' => ':attribute は整数である必要があります。',
    'ip' => ':attribute は有効なIPアドレスである必要があります。',
    'ipv4' => ':attribute は有効なIPv4アドレスである必要があります。',
    'ipv6' => ':attribute は有効なIPv6アドレスである必要があります。',
    'json' => ':attribute は有効なJSON文字列である必要があります。',
    'list' => ':attribute はリストである必要があります。',
    'lowercase' => ':attribute は小文字である必要があります。',
    'lt' => [
        'array' => ':attribute は :value 個より少ない項目である必要があります。',
        'file' => ':attribute は :value キロバイトより小さい必要があります。',
        'numeric' => ':attribute は :value より小さい必要があります。',
        'string' => ':attribute は :value 文字より少ない必要があります。',
    ],
    'lte' => [
        'array' => ':attribute は :value 個以下の項目である必要があります。',
        'file' => ':attribute は :value キロバイト以下である必要があります。',
        'numeric' => ':attribute は :value 以下である必要があります。',
        'string' => ':attribute は :value 文字以下である必要があります。',
    ],
    'mac_address' => ':attribute は有効なMACアドレスである必要があります。',
    'max' => [
        'array' => ':attribute は :max 個以下の項目である必要があります。',
        'file' => ':attribute は :max キロバイト以下である必要があります。',
        'numeric' => ':attribute は :max 以下である必要があります。',
        'string' => ':attribute は :max 文字以下である必要があります。',
    ],
    'max_digits' => ':attribute は :max 桁以下である必要があります。',
    'mimes' => ':attribute は次の形式のファイルである必要があります: :values',
    'mimetypes' => ':attribute は次の形式のファイルである必要があります: :values',
    'min' => [
        'array' => ':attribute は少なくとも :min 個の項目が必要です。',
        'file' => ':attribute は少なくとも :min キロバイト必要です。',
        'numeric' => ':attribute は :min 以上である必要があります。',
        'string' => ':attribute は :min 文字以上である必要があります。',
    ],
    'min_digits' => ':attribute は少なくとも :min 桁必要です。',
    'missing' => ':attribute は含めないでください。',
    'missing_if' => ':other が :value の場合、:attribute は含めないでください。',
    'missing_unless' => ':other が :value でない場合、:attribute は含めないでください。',
    'missing_with' => ':values が指定されている場合、:attribute は含めないでください。',
    'missing_with_all' => ':values がすべて指定されている場合、:attribute は含めないでください。',
    'multiple_of' => ':attribute は :value の倍数である必要があります。',
    'not_in' => '選択された :attribute は無効です。',
    'not_regex' => ':attribute の形式が無効です。',
    'numeric' => ':attribute は数値である必要があります。',
    'password' => [
        'letters' => ':attribute には少なくとも1文字の英字を含める必要があります。',
        'mixed' => ':attribute には大文字と小文字をそれぞれ少なくとも1文字含める必要があります。',
        'numbers' => ':attribute には少なくとも1文字の数字を含める必要があります。',
        'symbols' => ':attribute には少なくとも1文字の記号を含める必要があります。',
        'uncompromised' => '入力された :attribute は過去のデータ漏洩で確認されています。別の :attribute を選択してください。',
    ],
    'present' => ':attribute が存在している必要があります。',
    'present_if' => ':other が :value の場合、:attribute が存在している必要があります。',
    'present_unless' => ':other が :value でない場合、:attribute が存在している必要があります。',
    'present_with' => ':values が指定されている場合、:attribute が存在している必要があります。',
    'present_with_all' => ':values がすべて指定されている場合、:attribute が存在している必要があります。',
    'prohibited' => ':attribute は入力できません。',
    'prohibited_if' => ':other が :value の場合、:attribute は入力できません。',
    'prohibited_if_accepted' => ':other が承認されている場合、:attribute は入力できません。',
    'prohibited_if_declined' => ':other が拒否されている場合、:attribute は入力できません。',
    'prohibited_unless' => ':other が :values に含まれていない場合、:attribute は入力できません。',
    'prohibits' => ':attribute が指定されている場合、:other は入力できません。',
    'regex' => ':attribute の形式が無効です。',
    'required' => ':attribute は必須です。',
    'required_array_keys' => ':attribute には次の項目が必要です: :values',
    'required_if' => ':other が :value の場合、:attribute は必須です。',
    'required_if_accepted' => ':other が承認されている場合、:attribute は必須です。',
    'required_if_declined' => ':other が拒否されている場合、:attribute は必須です。',
    'required_unless' => ':other が :values に含まれていない場合、:attribute は必須です。',
    'required_with' => ':values が指定されている場合、:attribute は必須です。',
    'required_with_all' => ':values がすべて指定されている場合、:attribute は必須です。',
    'required_without' => ':values が指定されていない場合、:attribute は必須です。',
    'required_without_all' => ':values がいずれも指定されていない場合、:attribute は必須です。',
    'same' => ':attribute と :other は一致する必要があります。',
    'size' => [
        'array' => ':attribute は :size 個の項目である必要があります。',
        'file' => ':attribute は :size キロバイトである必要があります。',
        'numeric' => ':attribute は :size である必要があります。',
        'string' => ':attribute は :size 文字である必要があります。',
    ],
    'starts_with' => ':attribute は次のいずれかで始まる必要があります: :values',
    'string' => ':attribute は文字列である必要があります。',
    'timezone' => ':attribute は有効なタイムゾーンである必要があります。',
    'unique' => ':attribute は既に使用されています。',
    'uploaded' => ':attribute のアップロードに失敗しました。',
    'uppercase' => ':attribute は大文字である必要があります。',
    'url' => ':attribute は有効なURLである必要があります。',
    'ulid' => ':attribute は有効なULIDである必要があります。',
    'uuid' => ':attribute は有効なUUIDである必要があります。',

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
