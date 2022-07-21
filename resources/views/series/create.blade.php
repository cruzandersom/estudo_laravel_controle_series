<x-layout title="Nova Serie">

    <x-series.form :action="route('series.store')" :nome="old('nome')" :update="false"/>

</x-layout>
