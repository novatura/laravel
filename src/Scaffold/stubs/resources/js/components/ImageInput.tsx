import React, { useState } from 'react';
import { Stack, ActionIcon, FileButton, Box, Overlay, Button, Text } from "@mantine/core";
import { FileUp, X } from 'lucide-react';

const ImageInput = ({ onChange }) => {

    const [isHovered, setHovered] = useState(false);

    const handleHover = () => {
      setHovered(true);
    };
  
    const handleMouseLeave = () => {
      setHovered(false);
    };
  
    const handleRemove = () => {
        setFile(false);
        setImage(null);
        onChange(null);
    };
    
    const [file, setFile] = useState<boolean>(false);

    const [image, setImage] = useState(null);


    const handleImageChange = (e) => {

        setFile(true);
        onChange(e);

        if (e) {
            const reader = new FileReader();
            reader.onloadend = () => {
              setImage(reader.result);
            };
            reader.readAsDataURL(e);
        } else {
            setImage(null);
        }

    };

    return (
        <Stack>
            <Stack align="center">
                { file ? 
                    <div
                        className="image-container"
                        onMouseEnter={handleHover}
                        onMouseLeave={handleMouseLeave}
                    >
                        <Box sx={{ height: 100, position: 'relative' }}>
                            <img src={image} alt="Selected" style={{ maxWidth: '100%', maxHeight: '50px' }} />
                            {isHovered && (
                                <ActionIcon variant="outline" onClick={handleRemove}>
                                    <X />
                                </ActionIcon>
                            )}
                        </Box>
                    </div>

                :
                    <FileButton onChange={handleImageChange} accept="image/png,image/jpeg">
                        {(props) => 
                            <ActionIcon variant="default" size={42} {...props}>
                                <FileUp/>
                            </ActionIcon>}
                    </FileButton>
                }

            </Stack>
        </Stack>

    );
};

export default ImageInput;