@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/csv_preview.css') }}">
@endsection

@section('content')
    <div class="content">
        <h3 class="csv-preview__ttl">インポート内容の確認</h3>

        <div class="csv-preview__table">
            <table class="csv-preview__table--table">
                <tr class="csv-preview__row">
                    @foreach ($csvHeader as $header)
                        <th class="csv-preview__label">{{ $header }}</th>
                    @endforeach
                </tr>
                @foreach ($csvData as $data)
                <tr class="csv-preview__row">
                    @foreach ($data as $cell)
                        <td class="csv-preview__data">{{ $cell }}</td>
                    @endforeach
                </tr>
                @endforeach
            </table>
        </div>
        <div class="csv-import__form">
            <form action="{{ route('admin.import.csv') }}" method="POST">
                @csrf
                <input type="hidden" name="csvData" value="{{ json_encode($csvData) }}">
                <button type="button" onclick="history.back()" class="back__btn">戻る</button>
                <button class="csv-import__btn">インポート実行</button>
            </form>
        </div>
    </div>
@endsection
