SELECT object_id                                      as booster_pack_id,
       SUM(IF(action = 'buy boosterpack', amount, 0)) as spent,
       SUM(IF(action = 'like refill', amount, 0))     as get_likes,
       DATE_FORMAT(created_at, "%Y-%m-%d %H")         as hour
from analytics
where action IN ('like refill', 'buy boosterpack')
  and DATE(created_at) >= (DATE(NOW()) - INTERVAL 30 DAY)
GROUP BY object_id, hour
ORDER BY hour DESC, spent DESC;

SELECT users.id,
       users.wallet_total_refilled,
       a.*
FROM users
         Left Join analytics a on users.id = a.user_id
where action = 'wallet refill';

SELECT user_id,
       SUM(IF(action = 'wallet refill', amount, 0)) as balance,
       SUM(IF(action = 'like refill', amount, 0))   as likes,
       u.wallet_balance,
       u.likes_balance
from analytics
left join users u on analytics.user_id = u.id
where action IN ('like refill', 'wallet refill')
GROUP BY user_id
ORDER BY user_id;
