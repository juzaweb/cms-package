<?php

namespace Juzaweb\Traits;

trait ResponseMessage
{
    protected function response($data, $status)
    {
        if (! is_array($data)) {
            $data = [$data];
        }

        if (request()->has('redirect')) {
            $data['redirect'] = request()->input('redirect');
        }

        if (request()->ajax()) {
            return response()->json([
                'status' => $status,
                'data' => $data,
            ]);
        }

        $back = back()->withInput()->with(array_merge($data, [
            'status' => $status ? 'success' : 'error',
        ]));

        if (empty($status)) {
            $back->withErrors([$data['message']]);
        }

        return $back;
    }

    /**
     * Response success message
     *
     * @param string|array $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function success($message)
    {
        if (is_string($message)) {
            $message = ['message' => $message];
        }

        return $this->response($message, true);
    }

    /**
     * Response error message
     *
     * @param string|array $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function error($message)
    {
        if (is_string($message)) {
            $message = ['message' => $message];
        }

        return $this->response($message, false);
    }
}
