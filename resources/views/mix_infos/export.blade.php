<table>
    <thead>
        <tr>
            <th>{{ __('種付日') }}</th>
            <th>{{ __('メスNO') }}</th>
            <th>{{ __('オス1NO') }}</th>
            <th>{{ __('オス2NO') }}</th>
            <th>{{ __('確認日1') }}</th>
            <th>{{ __('確認日2') }}</th>
            <th>{{ __('分娩予定日') }}</th>
            <th>{{ __('分娩日') }}</th>
            <th>{{ __('生存') }}</th>
            <th>{{ __('死産') }}</th>
            <th>{{ __('離乳日') }}</th>
            <th>{{ __('離乳頭数') }}</th>
            <th>{{ __('id') }}</th>
            <th>{{ __('female.id') }}</th>
            <th>{{ __('male1.id') }}</th>
            <th>{{ __('male2.id') }}</th>
            <th>{{ __('first_recurrence') }}</th>
            <th>{{ __('second_recurrence') }}</th>
            <th>{{ __('trouble_day') }}</th>
            <th>{{ __('trouble_id') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($mixInfos as $mixInfo)
            <tr>
                <td>{{ $mixInfo->mix_day }}</td>
                <td>{{ $mixInfo->female_pig_with_trashed->individual_num }}</td>
                <td>{{ $mixInfo->first_male_pig_with_trashed->individual_num }}</td>
                <td>{{ $mixInfo->second_male_pig_with_trashed->individual_num }}</td>
                <td>{{ $mixInfo->first_recurrence_schedule }}</td>
                <td>{{ $mixInfo->second_recurrence_schedule }}</td>
                <td>{{ $mixInfo->delivery_schedule }}</td>
                <td>{{ $mixInfo->born_day }}</td>
                <td>{{ $mixInfo->born_num }}</td>
                <td>{{ $mixInfo->stillbirth_num }}</td>
                <td>{{ $mixInfo->weaning_day }}</td>
                <td>{{ $mixInfo->weaning_num }}</td>
                <td>{{ $mixInfo->id }}</td>
                <td>{{ $mixInfo->female_id }}</td>
                <td>{{ $mixInfo->first_male_id }}</td>
                <td>{{ $mixInfo->second_male_id }}</td>
                <td>{{ $mixInfo->first_recurrence }}</td>
                <td>{{ $mixInfo->second_recurrence }}</td>
                <td>{{ $mixInfo->trouble_day }}</td>
                <td>{{ $mixInfo->trouble_id }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
