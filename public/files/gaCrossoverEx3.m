function [popOut] = gaCrossoverEx3(popIn, pc)

% Detailed explanation goes here
popOut = popIn;
pcs = single(pc);
for i = 1:2:size(popIn,1)
    pcr = single(rand(1));
    if (pcr < pcs)
        cpoint = randi([2 size(popIn, 2)], 1); 
            x = popOut(i, cpoint:end);    % ตั้งแตตําแหนงบิตที่ 2–บิตสุดทาย (ซายไปขวา) 
            popOut(i, cpoint:end) = popOut(i+1, cpoint:end); % สลับแถวที่ i 
            popOut(i+1, cpoint:end) = x;
    end
end
end