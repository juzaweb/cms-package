<script type="text/javascript">
    /**
     * MYMO CMS - THE BEST LARAVEL CMS
     *
     * @package    juzacmscms/juzacmscms
     * @link       https://github.com/juzacmscms/juzacmscms
     * @license    MIT
     */

    var juzacms = {
        adminPrefix: "{{ config('juzacms.admin_prefix') }}",
        adminUrl: "{{ url(config('juzacms.admin_prefix')) }}",
        lang: @json(trans('juzacms::app'))
    }
</script>
