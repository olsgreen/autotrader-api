<?php

namespace Olsgreen\AutoTrader\Api;

use Olsgreen\AutoTrader\Api\Builders\LeadSummaryRequestBuilder;
use Olsgreen\AutoTrader\Api\Enums\LeadStatus;

class Leads extends AbstractApi
{
    /**
     * Index Leads ( Summary ).
     *
     * @param       $advertiserId
     * @param array $request
     *
     * @throws Builders\ValidationException
     *
     * @return array
     *
     * @see https://developers.autotrader.co.uk/api#index-leads-summary
     */
    public function summary($advertiserId, $request = [])
    {
        if (!($request instanceof LeadSummaryRequestBuilder)) {
            if (is_array($request)) {
                $request = LeadSummaryRequestBuilder::create($request);
            }

            // Throw an invalid argument exception if it's anything else.
            else {
                throw new \InvalidArgumentException(
                    'The $request argument must be an array or EnquirySummaryRequestBuilder.'
                );
            }
        }

        $params = array_merge($request->toArray(), [
            'retailerId' => $advertiserId,
        ]);

        return $this->_get('/service/leads-v1/leads/summary', $params);
    }

    /**
     * Retrieve a lead.
     *
     * @param string $leadId
     *
     * @return array
     *
     * @see https://developers.autotrader.co.uk/api#retrieve-a-lead
     */
    public function show(string $leadId)
    {
        return $this->_get(
            '/service/leads-v1/leads/'.$leadId,
        );
    }

    /**
     * Lead Messages.
     *
     * @param string $leadId
     *
     * @return array
     *
     * @see https://developers.autotrader.co.uk/api#lead-messages
     */
    public function messages(string $leadId)
    {
        return $this->_get(
            '/service/leads-v1/leads/'.$leadId.'/messages',
        );
    }

    /**
     * Reply to lead’s message.
     *
     * @param string $leadId
     * @param string $message
     *
     * @return array
     *
     * @see https://developers.autotrader.co.uk/api#retrieve-lead-messages
     */
    public function reply(string $leadId, string $message)
    {
        $jsonBody = json_encode([
            'sender'  => 'retailer',
            'payload' => [
                'type'    => 'text',
                'content' => $message,
            ],
        ], JSON_PRETTY_PRINT);

        return $this->_post(
            '/service/leads-v1/leads/'.$leadId.'/messages',
            [],
            $jsonBody,
            ['Content-Type' => 'application/json']
        );
    }

    /**
     * Update status of a lead.
     *
     * @param string $leadId
     * @param string $status
     *
     * @return array
     *
     * @see https://developers.autotrader.co.uk/api#update-status-of-a-lead
     */
    public function update(string $leadId, string $status)
    {
        if (!(new LeadStatus())->contains($status)) {
            throw new \InvalidArgumentException('Invalid status given.');
        }

        return $this->_put(
            '/service/leads-v1/leads/'.$leadId.'/status',
            [],
            $status,
            ['Content-Type' => 'text/plain']
        );
    }
}
